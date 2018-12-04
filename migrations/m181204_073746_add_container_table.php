<?php

use yii\db\Migration;

/**
 * Class m181204_073746_add_container_table
 */
class m181204_073746_add_container_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dbo.container', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'code'=>$this->string()->notNull(),
            'tonnage'=>$this->smallInteger()->notNull(),
            'active'=>$this->boolean()->defaultValue(1)->notNull(),
            'type_id'=>$this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_container_type_id',
            'dbo.container',
            'type_id',
            'dbo.container_type',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_container_type_id', 'dbo.container');
        $this->dropTable('dbo.container');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_073746_add_container_table cannot be reverted.\n";

        return false;
    }
    */
}
