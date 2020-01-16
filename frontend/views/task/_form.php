<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var $templates array */

?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if (!empty($templates)) { ?>
        <?= $form->field($model, 'template_id')->dropDownList($templates, ['prompt'=>'Без шаблона']) ?>
    <?php } ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <?= $form->field($model, 'executor_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php
    //вот здесь была проблема, я зачем то делал map от уже про-map-ленного набора
    //было так
    /* $form->field($model, 'priority')
        ->dropDownList(ArrayHelper::map(
                \common\models\Priority::getTaskPriorities(),
                'id',
                'title'
        ))

     */?>

    <?= //а надо было так
    $form->field($model, 'priority')
        ->dropDownList(\common\models\Priority::getTaskPriorities()) ?>

    <?= $form->field($model, 'status')->dropDownList(\common\models\Task::getStatusName()) ?>

    <?= $form->field($model, 'is_template')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
