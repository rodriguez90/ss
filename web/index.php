<?php

error_reporting(E_ERROR);
//ini_set('max_input_vars', 5000);
// SET THE INTERNAL ENCODING
//$charset = 'iso-8859-1';
//$charset = 'latin1';
//mb_internal_encoding($charset);
//mb_http_output($charset);

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
            if (!in_array($this->controller->action->id, ['login', 'about','register','getagencias','getagenciastrans']))
            {
                $_SESSION['redirect'] = Yii::$app->request->url;
                return $this->controller->redirect(Url::toRoute('site/login'));
            }
            else{
//                var_dump($this->controller->action->id);die;
            }
        }
        else
        {
            if (isset($_SESSION['redirect']))
            {
                $url = $_SESSION['redirect'];
                $_SESSION['redirect'] = null;
                unset( $_SESSION['redirect']);
                return $this->controller->redirect($url);
            }
        }
        return true;
    }
}

(new SGTApplication($config))->run();

