<?php

use yii\db\Migration;

/**
 * Class m181204_075726_add_line_table
 */
class m181204_075726_add_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dbo.line', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'code'=>$this->string()->notNull(),
            'oce'=>$this->string()->notNull(),
            'active'=>$this->boolean()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('dbo.line');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_075726_add_line_table cannot be reverted.\n";

        return false;
    }
    */
}
