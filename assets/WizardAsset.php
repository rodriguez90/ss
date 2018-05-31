<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 29/05/2018
 * Time: 3:40
 */

namespace app\assets;
use yii\web\AssetBundle;


class WizardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'plugins/bootstrap-wizard/css/bwizard.min.css',
//        'plugins/bootstrap-wizard/css/bwizard.css',
        'plugins/parsley/src/parsley.css',
    ];

    public $js = [
        'plugins/parsley/dist/parsley.js',
        'plugins/bootstrap-wizard/js/bwizard.js',
    ];

    public $depends = [
        'app\assets\SystemAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];
}