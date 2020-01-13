<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_log".
 *
 * @property int $id
 * @property string|null $username
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $message
 * @property int $type
 */
class ChatLog extends \yii\db\ActiveRecord
{

    const SHOW_HISTORY = 1;
    const SEND_MESSAGE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['created_at', 'updated_at', 'type'], 'integer'],
            [['username', 'type'], 'required'],
            [['message'], 'string'],
            [['username'], 'string', 'max' => 255],
        ];

        if ($this->type == self::SEND_MESSAGE) {
            $rules[] = [['message'], 'required'];
        }

        return $rules;
    }

    public function behaviors()
    {
        return [TimestampBehavior::class => ['class' => TimestampBehavior::class]];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'message' => 'Message',
        ];
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function create(array $data)
    {
        try {
            $model = new self(['username' => $data['username'], 'message' => $data['message'], 'type' => $data['type']]);
            if ($model->save()) {
                return true;
            } else {
                var_dump($model->errors);
            };
        } catch (\Throwable $throwable) {
            Yii::error($throwable->getTraceAsString());
            Yii::error(json_encode($data));
        }

    }
}
