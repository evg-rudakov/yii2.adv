<?php

use yii\db\Migration;

/**
 * Class m200116_165715_add_template_id_columt_to_task_table
 */
class m200116_165715_add_template_id_columt_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'task',
            'template_id',
            $this->integer());
        $this->addForeignKey(
            'fk-template-id_task',
            'task', 'template_id',
            'task', 'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-template-id_task', 'task');
        $this->dropColumn('task', 'template_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_165715_add_template_id_columt_to_task_table cannot be reverted.\n";

        return false;
    }
    */
}
