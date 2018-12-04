<?php

use yii\db\Migration;

/**
 * Class m181204_093151_add_process_transaction_table
 */
class m181204_093151_add_process_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( 'dbo.process_transaction', [
            'id'=>$this->primaryKey(),
            'process_id'=>$this->integer()->notNull(),
            'container_id'=>$this->integer()->notNull(),
            'trans_company_id'=>$this->integer()->notNull(),
            'register_truck'=>$this->string(),
            'register_driver'=>$this->string(),
            'name_driver'=>$this->string(),
            'delivery_date'=>$this->dateTime()->notNull(),
            'status'=>$this->integer()->notNull(),
            'active'=>$this->boolean()->notNull(),
            'container_alias'=>$this->string()
        ]);

        $this->addForeignKey(
            'fk_process_transaction_process_id',
            'dbo.process_transaction',
            'process_id',
            'dbo.process',
            'id'
        );

        $this->addForeignKey(
            'fk_process_transaction_transcompany_id',
            'dbo.process_transaction',
            'trans_company_id',
            'dbo.trans_company',
            'id'
        );

        $this->addForeignKey(
            'fk_process_transaction_container_id',
            'dbo.process_transaction',
            'trans_company_id',
            'dbo.container',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_process_transaction_process_id', 'dbo.process_transaction');
        $this->dropForeignKey('fk_process_transaction_transcompany_id', 'dbo.process_transaction');
        $this->dropForeignKey('fk_process_transaction_container_id', 'dbo.process_transaction');
        $this->dropTable('dbo.process_transaction');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_093151_add_process_transaction_table cannot be reverted.\n";

        return false;
    }
    */
}
