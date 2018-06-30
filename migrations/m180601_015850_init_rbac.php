<?php

use yii\db\Migration;
use app\modules\administracion\models\AdmUser;
/**
 * Class m180601_015850_init_rbac
 */
class m180601_015850_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adminUser = new AdmUser();
        $adminUser->username = 'root';
        $adminUser->auth_key = 'root';
        $adminUser->password = 'root';
        $adminUser->email = 'root@gmail.com';
        $adminUser->nombre = 'root';
        $adminUser->apellidos = 'root';
        $adminUser->creado_por = 'migration';
        $adminUser->status = 1;
        $adminUser->created_at =  date();
        $adminUser->updated_at =  date();

        $adminUser->save();

        // add "createPost" permission
        $createPost = $auth->createPermission('Admin_mod');
        $createPost->description = 'Administrador del sistema';
        $auth->add($createPost);


        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');

        $auth->add($admin);
        $auth->addChild($admin, $adminUser->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        echo "m180601_015850_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180601_015850_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
