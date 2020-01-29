<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $isSubscribed boolean */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="task-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <p>
            <?php if (!$isSubscribed) { ?>
                <?= Html::a('Subscribe', ['subscribe', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php } else { ?>
                <?= Html::a('Unsubscribe', ['unsubscribe', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <?php } ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'author_id',
                'executor_id',
                'title',
                'description:ntext',
                'priority.title',
                [
                    'attribute' => 'status',
                    'value' => function (\common\models\Task $model) {
                        return \common\models\Task::getStatusName()[$model->status];
                    }
                ],
                'created_at:datetime',
                'updated_at:datetime',
                'is_template:boolean'
            ],
        ]) ?>

    </div>
<?= \frontend\widgets\chat\Chat::widget(['task_id' => $model->id]) ?>