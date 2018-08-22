<?php
/**
 * Created by PhpStorm.
 * User: intetn2
 * Date: 18.07.2018
 * Time: 17:59
 */

namespace app\controllers;

use app\models\LoginForm;
use yii\base\Controller;

class loginController extends Controller
{
    public function actionIndex()
    {
        return $this->render('login/index.php', [
            'qwe' => 'qwe'
        ]);
    }
}