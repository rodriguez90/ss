<?php

namespace app\modules\Administracion;
use yii\web\ForbiddenHttpException;

/**
 * Admin module definition class
 */
class Administracion extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\administracion\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)){
            return false;
        }

        if(! \Yii::$app->user->can('Admin_mod'))
        {
            throw new ForbiddenHttpException('Acceso denegado');
            //return  \Yii::$app->controller->redirect(\Yii::$app->homeUrl . '/site/login');
        }
        return true;
    }

}
