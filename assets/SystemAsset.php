<?php

namespace app\assets;

use yii\web\AssetBundle;

class SystemAsset extends  AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'plugins/jquery-ui/themes/base/minified/jquery-ui.min.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'css/animate.min.css',
        'css/style.min.css',
        'css/style-responsive.min.css',
        'css/theme/default.css',
        'plugins/bootstrap-datepicker/css/datepicker.css',
        'plugins/bootstrap-datepicker/css/datepicker3.css',
        'plugins/gritter/css/jquery.gritter.css',
        'plugins/morris/morris.css',
        //yopt
        'plugins/password-indicator/css/password-indicator.css',
        'plugins/jstree/dist/themes/default/style.min.css',
    ];
    public $js = [
//        'plugins/jquery/jquery-1.9.1.min.js',
        'plugins/jquery/jquery-migrate-1.1.0.min.js',
        'plugins/jquery-ui/ui/minified/jquery-ui.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
        'plugins/jquery-cookie/jquery.cookie.js',
        'plugins/gritter/js/jquery.gritter.js',
        'plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',

        //yopt
        "plugins/jquery-ui/ui/minified/jquery-ui.min.js",
        'plugins/parsley/dist/parsley.js',
        'plugins/password-indicator/js/password-indicator.js',
        'plugins/jstree/dist/jstree.min.js',
        'plugins/pace/pace.min.js',

        'js/apps.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];

}