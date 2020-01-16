<?php

use yii\db\Migration;

/**
 * Class m200116_175924_add_type_to_priority_table
 */
class m200116_175924_add_type_to_priority_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('priority', 'type', $this->tinyInteger());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('priority', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_175924_add_type_to_priority_table cannot be reverted.\n";

        return false;
    }
    */
}
