<?php

use yii\db\Migration;

/**
 * Class m200120_170625_add_task_id_project_id_to_chat_log_table
 */
class m200120_170625_add_task_id_project_id_to_chat_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat_log', 'task_id', $this->integer());
        $this->addColumn('chat_log', 'project_id', $this->integer());

        $this->addForeignKey(
            'fk-chat_log_task_id',
            'chat_log',
            'task_id', 'task',
            'id');

        $this->addForeignKey(
            'fk-chat_log_project_id',
            'chat_log',
            'project_id', 'project',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-chat_log_task_id', 'chat_log');
        $this->dropForeignKey('fk-chat_log_project_id', 'chat_log');
        $this->dropColumn('chat_log', 'task_id');
        $this->dropColumn('chat_log', 'project_id');
    }

}
