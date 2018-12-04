<?php

use yii\db\Migration;

/**
 * Class m181204_065125_add_agency_table
 */
class m181204_065125_add_agency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->createTable('dbo.agency', [
                'id'=>$this->primaryKey(),
                'name'=>$this->string()->notNull(),
                'code_oce'=>$this->string()->notNull(),
                'ruc'=>$this->string()->notNull(),
                'active'=>$this->boolean()->defaultValue(1),
            ]);

        $this->createTable('dbo.user_agency', [
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'agency_id'=>$this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_user_agency_user_id',
            'dbo.user_agency',
            'user_id',
            'dbo.adm_user',
            'id'
        );

        $this->addForeignKey(
            'fk_user_agency_agency_id',
            'dbo.user_agency',
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
        $this->dropForeignKey('fk_user_agency_user_id', 'dbo.user_agency');
        $this->dropForeignKey('fk_user_agency_agency_id', 'dbo.user_agency');
        $this->dropTable('dbo.user_agency');
        $this->dropTable('dbo.agency');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_065125_add_agency_table cannot be reverted.\n";

        return false;
    }
    */
}
