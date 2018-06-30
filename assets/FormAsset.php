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
        'plugins/bootstrap-select/bootstrap-select.min.css',
        'plugins/password-indicator/css/password-indicator.css',
        'plugins/parsley/src/parsley.css',
        'plugins/ionRangeSlider/css/ion.rangeSlider.css',
        'plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css',
        'plugins/bootstrap-combobox/js/bootstrap-combobox.js'
    ];

    public $js = [
        'plugins/switchery/switchery.min.js',
        'js/form-slider-switcher.js',
        'plugins/bootstrap-select/bootstrap-select.min.js',
        'plugins/select2/dist/js/select2.min.js',
        'plugins/select2/dist/js/i18n/es.js',
        'plugins/parsley/dist/parsley.js',
        'plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js',
        'plugins/bootstrap-combobox/js/bootstrap-combobox.js'
    ];

    public $depends = [
        'app\assets\SystemAsset',
    ];
}