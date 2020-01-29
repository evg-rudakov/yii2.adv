<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_subscriber".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $task_id
 * @property int|null $type
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class TaskSubscriber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const DEFAULT_TYPE = 1;
    public static function tableName()
    {
        return 'task_subscriber';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'created_at', 'updated_at', 'task_id'], 'integer'],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function subscribe($user_id, $task_id)
    {
        $model = self::find()->where(['user_id' => $user_id, 'task_id' => $task_id])->one();
        if (!isset($model)) {
            $model = new self();
            $model->user_id = $user_id;
            $model->task_id = $task_id;
            $model->type = self::DEFAULT_TYPE;
            return $model->save();
        }

        return true;
    }

    public static function unsubscribe($user_id, $task_id)
    {
        self::deleteAll(['user_id' => $user_id, 'task_id' => $task_id]);

        return true;
    }


    /**
     * @param $user_id
     * @param $task_id
     * @return bool
     */
    public static function isSubscribed($user_id, $task_id)
    {
        return self::find()->where(['user_id' => $user_id, 'task_id' => $task_id])->exists();

    }
}
