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
    ];

    public $js = [
        'plugins/bootstrap-wizard/js/bwizard.js',
    ];

    public $depends = [
        'app\assets\SystemAsset',
    ];
}