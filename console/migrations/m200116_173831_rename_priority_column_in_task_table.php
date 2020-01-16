<?php

use yii\db\Migration;

/**
 * Class m200116_173831_rename_priority_column_in_task_table
 */
class m200116_173831_rename_priority_column_in_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('task','priority',  'priority_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('task','priority_id','priority');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_173831_rename_priority_column_in_task_table cannot be reverted.\n";

        return false;
    }
    */
}
