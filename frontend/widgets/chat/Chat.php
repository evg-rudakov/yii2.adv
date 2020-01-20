<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 20/01/2020
 * Time: 19:29
 */

namespace frontend\widgets\chat;

class Chat extends \yii\base\Widget
{
    public $username;

    public $task_id;

    public $project_id;

    public function init()
    {
        parent::init();

        ChatAsset::register($this->view);

        if (\Yii::$app->user->isGuest) {
            $this->username = 'guest_' . time();
        } else {
            $this->username = \Yii::$app->user->identity->username;
        }

        $this->view->registerMetaTag(['name'=>'chat-widget-project-id', 'content'=>$this->project_id]);
        $this->view->registerMetaTag(['name'=>'chat-widget-task-id', 'content'=>$this->task_id]);
        $this->view->registerMetaTag(['name'=>'chat-widget-username', 'content'=>$this->username]);
    }


    public function run()
    {
        return $this->render('index');
    }
}