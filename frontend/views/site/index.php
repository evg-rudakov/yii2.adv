<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead"><?= \common\helpers\GeekHelper::brains(['hello' => 'hello']) ?></p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <?= \yii\helpers\Html::a("Показать дату", 'js:', ['class' => 'btn btn-lg btn-primary js-set-data']) ?>
                <?= \yii\helpers\Html::a("Показать время", 'js:', ['class' => 'btn btn-lg btn-success js-get-time']) ?>
                <h1 class="js-set-data">Сейчас: <?= $response ?></h1>
            </div>
            <div class="col-lg-4">
                <h2><?= \yii\helpers\Url::to(['@frontend', 'id'=>1, 'ne_id'=>2]) ?></h2>
                <h2><?= \yii\helpers\Url::toRoute(['site/about', 'id'=>1, 'ne_id'=>2]) ?></h2>


                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
<?php
$js = <<<JS
    $(document).on('.js-get-time','click', function () {
        debugger;
        $.ajax({
            url:'/site/time'
        }).success(function (data) {
            console.log(data);
            $('.js-set-data').html(data.time)
        })
    });
JS;

$this->registerJs($js, yii\web\View::POS_LOAD);

?>

