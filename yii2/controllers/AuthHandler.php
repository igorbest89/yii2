<?php
namespace app\controllers;

use app\models\Auth;
use app\models\SocialAuth;
use app\models\User;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $etag = ArrayHelper::getValue($attributes, 'etag');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');
        $email = $attributes['emails'][0]['value'];

        /* @var Auth $auth */
        $auth = SocialAuth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) {
                /**
                 * if exist user
                 */
            } else { // signup
                if ($email !== null && User::find()->where(['user_email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'user_name' => $nickname,
                        'user_password' => $password,
                        'user_email' => $email,
                        'user_token' => $etag,
                    ]);
//                    $user->generateAuthKey();
//                    $user->generatePasswordResetToken();

                    $transaction = User::getDb()->beginTransaction();

                    if ($user->save()) {
                        $auth = new SocialAuth([
                            'user_id' => $user->user_id,
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    }
                }
            }
        }
    }


    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }
    }
}