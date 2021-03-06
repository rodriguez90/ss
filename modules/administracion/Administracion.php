<?php

namespace app\modules\Administracion;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use Yii;

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


        if (Yii::$app->user->isGuest)
        {
            return Yii::$app->controller->redirect( Url::to(['/site/login']) );
        }

        return true;
    }

}
