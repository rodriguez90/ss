<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';


(new yii\web\Application($config))->run();
//
//class SGTApplication extends yii\web\Application
//{
//
//    public function init()
//    {
//        return parent::init();
//    }
//
//    public function beforeAction($action)
//    {
//
//        if (!parent::beforeAction($action))
//        {
//            return false;
//        }
//
//        if ($this->user->isGuest)
//        {
//            if (!in_array($this->controller->action->id,
//                [
//                    'login',
//                    'about'
//                ]))
//            {
////                var_dump($this->homeUrl . '/site/login');die;
////                \yii\helpers\Url::to(['/site/login'])
////                return $this->controller->redirect( \yii\helpers\Url::to(['/site/login']));
////                return $this->controller->redirect($this->homeUrl . '/site/login');
//                  return $this->controller->redirect('/site/login');
////                var_dump("pase x la app");die;
//            }
//        }
//
//        return true;
//    }
//
//}
//
//(new SGTApplication($config))->run();

