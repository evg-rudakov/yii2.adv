<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m200116_141459_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'author_id'=>$this->integer(),
            'executor_id'=>$this->integer(),
            'title'=>$this->string(),
            'description'=>$this->text(),
            'priority'=>$this->tinyInteger(),
            'status'=>$this->tinyInteger(),
            'created_at'=>$this->bigInteger(),
            'updated_at'=>$this->bigInteger(),
        ]);
        $this->addForeignKey('fk-task-author_id', 'task', 'author_id','user', 'id');
        $this->addForeignKey('fk-task-executor_id', 'task', 'executor_id','user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-author_id', 'task');
        $this->dropForeignKey('fk-task-executor_id', 'task');
        $this->dropTable('{{%task}}');
    }
}
