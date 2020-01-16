<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int|null $template_id
 * @property int|null $author_id
 * @property int|null $executor_id
 * @property int|null $project_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $priority_id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property boolean $is_template
 *
 * @property Task $template
 * @property User $author
 * @property User $executor
 * @property Priority $priority
 * @property Project $project
 */
class Task extends \yii\db\ActiveRecord
{

    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_DONE = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    public function beforeValidate()
    {
        if (!empty($this->template_id)) {
            $template = $this->template;
            $this->description = $template->description;
            $this->title = $template->title;
        }

        return parent::beforeValidate();
    }


    public function behaviors()
    {
        return [TimestampBehavior::class => ['class' => TimestampBehavior::class]];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_template'], 'boolean'],
            [['author_id', 'executor_id', 'priority_id', 'status', 'created_at', 'updated_at', 'template_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['template_id' => 'id']],
            [['priority_id'], 'exist', 'skipOnError' => false, 'targetClass' => Priority::class, 'targetAttribute' => ['priority_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'executor_id' => 'Executor ID',
            'title' => 'Title',
            'description' => 'Description',
            'priority_id' => 'Priority',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_template'=>'is template?'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Task::class, ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPriority()
    {
        return $this->hasOne(Priority::class, ['id' => 'priority_id'])->where(['priority.type'=>Priority::TYPE_TASK]);
    }

    public static function getStatusName()
    {
        return [
            static::STATUS_NEW => "New",
            static::STATUS_IN_PROGRESS => "In progress",
            static::STATUS_DONE => "Done",
        ];
    }
}
