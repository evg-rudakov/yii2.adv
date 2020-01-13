<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 13/01/2020
 * Time: 19:34
 */

namespace frontend\controllers;


use yii\web\Controller;

class ChatController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');

    }

}