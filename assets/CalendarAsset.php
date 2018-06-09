<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 08/06/2018
 * Time: 1:54
 */

namespace app\assets;

use yii\web\AssetBundle;

class CalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/fullcalendar/fullcalendar.css',
    ];
    public $js = [
        'plugins/fullcalendar/fullcalendar.js',
    ];
    public $depends = [
        'app\assets\SystemAsset',
    ];
}