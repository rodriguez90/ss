<?php

use yii\db\Migration;

/**
 * Class m181203_141709_rbac_tables
 */
class m181203_141709_rbac_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->createTable('dbo.adm_user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64)->notNull()->unique(),
            'auth_key' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'cedula' => $this->string()->notNull(),
            'nombre' => $this->string()->notNull(),
            'apellidos' => $this->string()->notNull(),
            'creado_por' => $this->integer(11),
            'status' => $this->boolean()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk_auth_assignment_user_id',
            'dbo.auth_assignment',
            'user_id',
            'dbo.adm_user',
            'username'
        );
        $this->addForeignKey(
            'fk_adm_user_creado_por',
            'dbo.adm_user',
            'creado_por',
            'dbo.adm_user',
            'id'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_auth_assignment_user_id', 'dbo.auth_assignment');
        $this->dropForeignKey('fk_adm_user_creado_por', 'dbo.adm_user');
        $this->dropTable('dbo.adm_user');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181203_141709_rbac_tables cannot be reverted.\n";

        return false;
    }
    */
}
