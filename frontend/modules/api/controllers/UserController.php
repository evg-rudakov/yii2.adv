<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 23.01.2020
 * Time: 20:24
 */

namespace frontend\modules\api\controllers;


use common\models\User;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = User::class;
}