<?php

use yii\db\Migration;

/**
 * Class m181204_080125_add_trans_company_table
 */
class m181204_080125_add_trans_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('dbo.trans_company', [
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'ruc'=>$this->string()->notNull(),
            'address'=>$this->text(),
            'active'=>$this->boolean()->defaultValue(1),
        ]);

        $this->createTable('dbo.trans_company_phone', [
            'id'=>$this->primaryKey(),
            'phone_number'=>$this->string()->notNull(),
            'trans_company_id'=>$this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_trans_company_phone',
            'dbo.trans_company_phone',
            'trans_company_id',
            'dbo.trans_company',
            'id'
        );

        $this->createTable('dbo.user_transcompany', [
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'trans_company_id'=>$this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk_user_transcompany_user_id',
            'dbo.user_transcompany',
            'user_id',
            'dbo.adm_user',
            'id'
        );

        $this->addForeignKey(
            'fk_user_transcompany_transcompany_id',
            'dbo.user_transcompany',
            'trans_company_id',
            'dbo.trans_company',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_transcompany_user_id', 'user_transcompany');
        $this->dropForeignKey('fk_user_transcompany_transcompany_id', 'user_transcompany');
        $this->dropForeignKey('fk_trans_company_phone', 'trans_company_phone');

        $this->dropTable('dbo.user_transcompany');
        $this->dropTable('dbo.trans_company_phone');
        $this->dropTable('dbo.trans_company');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181204_080125_add_trans_company_table cannot be reverted.\n";

        return false;
    }
    */
}
