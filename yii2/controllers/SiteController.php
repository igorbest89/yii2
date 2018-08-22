<?php

namespace app\controllers;

use app\core\controllers\CoreController;
use app\models\Cities;
use app\models\Countries;
use app\models\Cv;
use app\models\Language;
use app\models\Mail;
use app\models\Signup;
use app\models\UrlLocalization;
use Yii;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\ConfirmRegistration;

class SiteController extends CoreController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {

        $Countries = Countries::find()->where(['is_active' => true])->with('languageRelation')->all();
        $countryFlag = Countries::findOne(['code' =>
            Language::findOne(['language_id' => Yii::$app->params['currentLang'] ? Yii::$app->params['currentLang'] : Yii::$app->params['defaultLang']])]);
        $cvCount = Cv::getAllCvCount();
        return $this->render('index', [
            'countryFlag' => $countryFlag,
            'flags' => $Countries,
            'cvCount' => $cvCount,
            'email' => (!empty(Yii::$app->request->get()['refEmail'])) ? Yii::$app->request->get()['refEmail'] : ''
        ]);
    }

    /**
     * @return string|Response
     */

    public function actionLogin()
    {
        if (!Yii::$app->getUser()->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionQwe()
    {
        echo 'qwe';
    }
    /**
     * @return string|Response
     */

    public function actionSignup()
    {
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionContact()
    {
        $formdata = [];
        parse_str(Yii::$app->request->post('form'), $formdata);//
        $request = $formdata["g-recaptcha-response"];
        $email = $formdata["userEmail"];
        $textBody = $formdata["textBody"];
        $userName = $formdata["userName"];
        if(!empty($request) && !empty($textBody) && !empty($email) && !empty($userName)) {
            $data = array(
                'secret' => '6LdLq2QUAAAAAGbYphk9vd1Lirl9WuA4KB4VoLCG',
                'response' =>  $request,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            );
            $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $captcha_success = json_decode($server_output);
            curl_close($ch);

            if ($captcha_success->success == false) {
                return false;
            } else if ($captcha_success->success == true) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                Mail::mailContactSend($email,$userName,$textBody);
                return ['status' => true];
        }
        }
        return $this->render('contact');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionConfirm()
    {
//        print_r(Yii::$app->request->get()); exit;
        $confirmData = Yii::$app->request->get();

        if (ConfirmRegistration::confirmUser($confirmData)) {
            User::sendData('userConfirm', $confirmData);
        }

    }
    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
        return $this->redirect('/registration',302);
    }
    public function actionFaq()
    {
        return $this->render('faq.phtml');
    }

}

