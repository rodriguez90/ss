<?php

use yii\db\Migration;

/**
 * Class m181204_065628_add_warehouse_table
 */
class m181204_065628_add_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dbo.warehouse', [
            'id'=>$this->primaryKey(),
            'code_oce'=>$this->integer()->notNull(),
            'name'=>$this->string()->notNull(),
            'ruc'=>$this->string()->notNull(),
            'active'=>$this->boolean()->defaultValue(1),
        ]);

        $this->addForeignKey(
            'fk_calendar_warehouse',
            'dbo.calendar',
            'id_warehouse',
            'dbo.warehouse',
            'id'
        );

        $this->createTable('dbo.user_warehouse', [
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'warehouse_id'=>$this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_user_warehouse_user_id',
            'dbo.user_warehouse',
            'user_id',
            'dbo.adm_user',
            'id'
        );

        $this->addForeignKey(
            'fk_user_warehouse_ware_house_id',
            'dbo.user_warehouse',
            'warehouse_id',
            'dbo.warehouse',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_warehouse_user_id', 'dbo.user_warehouse');
        $this->dropForeignKey('fk_user_warehouse_ware_house_id', 'dbo.user_warehouse');
        $this->dropForeignKey('fk_calendar_warehouse', 'calendar');

        $this->dropTable('dbo.user_warehouse');
        $this->dropTable('dbo.warehouse');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_065628_add_warehouse_table cannot be reverted.\n";

        return false;
    }
    */
}
