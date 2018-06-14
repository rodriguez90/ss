<?php

error_reporting(E_ERROR);
use yii\helpers\Url;
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';



class SGTApplication extends yii\web\Application
{

    public function init()
    {
        return parent::init();
    }

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action))
        {
            return false;
        }

        if ($this->user->isGuest)
        {
//            $session = Yii::$app->session;
//            $urlBeforeLogin = Yii::$app->request->url;
//////            var_dump($urlBeforeLogin); //die;
//////            var_dump($session->id); die;
////
//            if(!empty($urlBeforeLogin))
//            {
////                if(!$session->isActive)
//                    $session->open();
//
//                $url = Yii::$app->session->get('urlBeforeLogin');
////                var_dump($url);//die;
//                if(empty($url) || $urlBeforeLogin !== $url)
//                {
////                    var_dump($urlBeforeLogin);die;
////                    Yii::$app->session['urlBeforeLogin'] = $urlBeforeLogin;
//                    $session->set('urlBeforeLogin', $urlBeforeLogin);
////                    var_dump($session->get('urlBeforeLogin'));die;
//                }
            if (!in_array($this->controller->action->id, ['login', 'about']))
            {
//                var_dump(Yii::$app->request->url);die;
                $_SESSION['redirect'] = Yii::$app->request->url;
                //var_dump($this->homeUrl . '/site/login');die;
//                \yii\helpers\Url::to(['/site/login'])
//                return $this->controller->redirect( \yii\helpers\Url::to(['/site/login']));
                return $this->controller->redirect($this->homeUrl . '/site/login');//
            }
        }
        else
        {
            if (isset($_SESSION['redirect'])) {
                $url = $_SESSION['redirect'];
                $_SESSION['redirect'] = null;
                unset( $_SESSION['redirect']);
//                var_dump($url);die;
                return $this->controller->redirect($url);
            }
        }
        return true;
    }
}

(new SGTApplication($config))->run();

