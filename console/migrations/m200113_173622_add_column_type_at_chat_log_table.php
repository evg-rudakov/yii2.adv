<?php

use yii\db\Migration;

/**
 * Class m200113_173622_add_column_type_at_chat_log_table
 */
class m200113_173622_add_column_type_at_chat_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat_log', 'type', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('chat_log', 'type');
    }

}
