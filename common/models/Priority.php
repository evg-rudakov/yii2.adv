<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "priority".
 *
 * @property int $id
 * @property int $type
 * @property string|null $title
 * @property string|null $order
 */
class Priority extends \yii\db\ActiveRecord
{
    const TYPE_PROJECT = 1;
    const TYPE_TASK = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'priority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['title', 'order'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'order' => 'Order',
            'type' => 'Type',
        ];
    }

    /**
     * @return Priority[]
     */
    public static function getTaskPriorities()
    {
        return ArrayHelper::map(
            self::find()
                ->where([
                    'type' => self::TYPE_TASK
                ])
                ->asArray()
                ->orderBy('order')
                ->all(),
            'id',
            'title');
    }
}
