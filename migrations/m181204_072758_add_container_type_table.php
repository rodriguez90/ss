<?php

use yii\db\Migration;

/**
 * Class m181204_072758_add_container_type_table
 */
class m181204_072758_add_container_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dbo.container_type', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'code'=>$this->string()->notNull(),
            'tonnage'=>$this->smallInteger()->notNull(),
            'active'=>$this->boolean()->defaultValue(1)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dbo.container_type');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_072758_add_container_type_table cannot be reverted.\n";

        return false;
    }
    */
}
