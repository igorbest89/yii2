<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Openbuildings\Swiftmailer\CssInlinerPlugin;
class Mail extends Model
{
    public static function mailConfirmNewEmailSent($email, $pwd) {

        $tmpPwd = sha1('confirm_link' . $email);
//        $pwd = sha1($pwd);
        $pwd = Yii::$app->security->generatePasswordHash($pwd);
        TempPassword::createTempPassword($email, $pwd, $tmpPwd);
        $emailLink = Url::base(true) . '/registration?tmpPwd=' . $tmpPwd;

        $cssToInlineStyles = new CssToInlineStyles();

        $html = file_get_contents(__DIR__ . '/../web/templates/D31/index.html');
        $res1 = str_replace('name',$email,$html);
        $html = str_replace('url',$emailLink,$res1);
        $css = file_get_contents(__DIR__ . '/../web/templates/D31/css/style.css');
        $result = $cssToInlineStyles->convert(
            $html,
            $css
        );

        if(Yii::$app->params['mailDebug']) {
            Yii::$app->mailer->compose()
                ->setHtmlBody($result)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($email)
                ->setSubject('Confirm Registration DROPCV')
                ->send();
        }
    }

    public static function mailInvitationSent($email, $name,$tmpInvitation,$ref_id) {

        $emailLink = Url::base(true) . '/registration/invitation-confirm?refEmail=' . $email.'&tmpInvitation='.$tmpInvitation.'&refId='.$ref_id;       ;

        if(Yii::$app->params['mailDebug']) {
            $cssToInlineStyles = new CssToInlineStyles();

            $html = file_get_contents(__DIR__ . '/../web/templates/D31/index.html');
            $res1 = str_replace('name',$name,$html);
            $html = str_replace('url',$emailLink,$res1);
            $css = file_get_contents(__DIR__ . '/../web/templates/D31/css/style.css');
            $result = $cssToInlineStyles->convert(
                $html,
                $css
            );
            Yii::$app->mailer->compose()
                ->setHtmlBody($result)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($email)
                ->setSubject('Registration on DROPCV')
                ->send();

        }
    }
    public static function mailResetPasswordSent($email,$userToken) {

        $emailLink = Url::base(true) . '/account/forgot?userToken='.$userToken;

        if(Yii::$app->params['mailDebug']) {
//            $cssToInlineStyles = new CssToInlineStyles();

//            $html = file_get_contents(__DIR__ . '/../web/templates/D31/index.php.html');
//            $res1 = str_replace('name',$name,$html);
//            $html = str_replace('url',$emailLink,$res1);
//            $css = file_get_contents(__DIR__ . '/../web/templates/D31/css/style.css');
//            $result = $cssToInlineStyles->convert(
//                $html,
//                $css
//            );
            Yii::$app->mailer->compose()
                ->setTextBody($emailLink)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($email)
                ->setSubject('Registration on DROPCV')
                ->send();

        }
    }

    public static function mailContactSend($userEmail,$userName,$textBody)
    {
        Yii::$app->mailer->compose()
            ->setTextBody($textBody)
            ->setFrom($userEmail)
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('contact form dropcv.io')
            ->send();

    }
}

