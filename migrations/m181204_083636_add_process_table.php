<?php

use yii\db\Migration;

/**
 * Class m181204_083636_add_process_table
 */
class m181204_083636_add_process_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable( 'dbo.process', [
            'id'=>$this->primaryKey(),
            'bl'=>$this->string()->notNull(),
            'agency_id'=>$this->integer()->notNull(),
            'active'=>$this->boolean()->defaultValue(1),
            'type'=>$this->integer()->notNull(),
            'delivery_date'=>$this->dateTime()->notNull(),
            'created_at'=>$this->dateTime()->notNull()
        ]);

        $this->addForeignKey(
            'fk_process_agency_id',
            'dbo.process',
            'agency_id',
            'dbo.agency',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey('fk_process_agency_id', 'dbo.process');
        $this->dropTable('dbo.process');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_083636_add_process_table cannot be reverted.\n";

        return false;
    }
    */
}
