<?php
/**
 * Created by PhpStorm.
 * User: evg
 * Date: 20/01/2020
 * Time: 19:34
 */

namespace frontend\widgets\chat;


use yii\web\AssetBundle;
use yii\web\YiiAsset;

class ChatAsset extends AssetBundle
{
    public $sourcePath = (__DIR__ . '/assets');
    public $js = ['js/chat.js'];
    public $css = ['css/chat.css'];

    public $depends = [
        YiiAsset::class
    ];

    public function init()
    {
        $a=1;
        parent::init(); // TODO: Change the autogenerated stub
    }
}