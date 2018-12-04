<?php

use yii\db\Migration;

/**
 * Class m181204_065330_add_calendar_table
 */
class m181204_065330_add_calendar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dbo.calendar', [
            'id'=>$this->primaryKey(),
            'id_warehouse'=>$this->integer()->notNull(),
            'start_datetime'=>$this->dateTime()->notNull(),
            'end_datetime'=>$this->dateTime()->notNull(),
            'amount'=>$this->integer()->notNull(),
            'active'=>$this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dbo.calendar');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_065330_add_calendar_table cannot be reverted.\n";

        return false;
    }
    */
}
