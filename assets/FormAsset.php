<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 29/05/2018
 * Time: 1:49
 */

namespace app\assets;
use yii\web\AssetBundle;



class FormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'plugins/switchery/switchery.min.css',
        'plugins/select2/dist/css/select2.min.css',
        'plugins/bootstrap-select/bootstrap-select.min.css'
    ];

    public $js = [
        'plugins/switchery/switchery.min.js',
        //'js/form-slider-switcher.demo.min.js',
        'js/form-slider-switcher.js',
        'plugins/bootstrap-select/bootstrap-select.min.js',
        "plugins/select2/dist/js/select2.min.js"
    ];

    public $depends = [
        'app\assets\SystemAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];
}