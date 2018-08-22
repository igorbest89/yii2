<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 01.08.2018
 * Time: 18:51
 */

namespace app\controllers;


use app\core\controllers\CoreController;

class localController extends CoreController
{
    public $defaultAction = 'index';
    public function actionIndex()
    {
        die('worked');

    }

}