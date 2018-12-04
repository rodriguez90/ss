<?php

use yii\db\Migration;

/**
 * Class m181204_094124_add_ticket_table
 */
class m181204_094124_add_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( 'dbo.ticket', [
            'id'=>$this->primaryKey(),
            'process_transaction_id'=>$this->integer()->notNull(),
            'calendar_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'active'=>$this->boolean()->defaultValue(1),
            'acc_id'=>$this->integer(),
            'created_at'=>$this->dateTime()->notNull()
        ]);

        $this->addForeignKey(
            'fk_ticket_process_calendar_id',
            'dbo.ticket',
            'process_transaction_id',
            'dbo.process_transaction',
            'id'
        );

        $this->addForeignKey(
            'fk_ticket_process_transaction_id',
            'dbo.ticket',
            'calendar_id',
            'dbo.calendar',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_ticket_process_transaction_id', 'dbo.ticket');
        $this->dropForeignKey('fk_ticket_process_calendar_id', 'dbo.ticket');
        $this->dropTable('dbo.ticket');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_094124_add_ticket_table cannot be reverted.\n";

        return false;
    }
    */
}
