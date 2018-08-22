<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 30.07.2018
 * Time: 20:13
 */

namespace app\controllers;

use yii\web\Controller;
use app\models\Post;
class PostController extends Controller
{
    public function actionIndex(){
        $model = Post::find()->asArray()->all();
        $this->render('index',[
           'model' => $model
        ]);
    }

}