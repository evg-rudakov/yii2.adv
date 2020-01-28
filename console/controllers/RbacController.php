<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 27.01.2020
 * Time: 20:08
 */

namespace console\controllers;


use common\models\User;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $developerRole = $auth->createRole('developer');
        $auth->add($developerRole);


        $developers = User::find()->where(['!=', 'username', 'admin']);
        foreach ($developers->each() as $developer) {
            /** @var User $developer */
            $auth->assign($developerRole, $developer->id);
        }

        $admins = User::find()->where(['=', 'username', 'admin']);

        foreach ($admins->each() as $admin) {
            /** @var User $admin */
            $auth->assign($adminRole, $admin->id);
        }



    }

}