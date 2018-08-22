<?php

namespace app\controllers;

use app\core\controllers\CoreController;
use Yii;
use app\models\User;
use yii\web\HttpException;
use yii\helpers\Url;

class ApiController extends CoreController
{

    /**
     *Disable validation _csrf for opportunity to creating a valid post requests
     */
    public function init()
    {
        $this->enableCsrfValidation = false;
    }

    public $params = [];

    /**
     *Method for get user profile data by email and password(with using REST API methods)
     *
     * @throws HttpException
     */
    public function actionIndex()
    {
        Url::remember();
        $url =  Url::previous();
        $params['action'] = "";
        $versionValue = (substr($url, (strpos($url, 'api/') + 4)));
        $version = (!empty($versionValue)) ? $versionValue : 'v1';
//        echo $version; exit;

        if (!empty(Yii::$app->request->post())) {
            $params = Yii::$app->request->post();
        } else {
            throw new HttpException(400, 'Request is empty! Please, send a valid request.');
        }

        switch ($version) {
            case 'v1' : {
                return self::version1($params);

                break;
            }

            default : {
                return 'Non-existent version';

                break;
            }
        }
    }

    public static function version1($params)
    {
        switch ($params['action']) {
            case 'login' : {
                return User::getUserData($params['email'], $params['password']);

                break;
            }

            default : {
                return 'Non-existent action';

                break;
            }
        }
    }

    /**
     * Method for testing working capacity of REST API methods
     *
     * @return string
     */
    public function actionTest()
    {
        return 'TEST';
    }
}