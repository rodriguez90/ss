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
		'plugins/bootstrap-select/bootstrap-select.min.css',
    ];
    public $js = [
        'plugins/fullcalendar/lib/moment.min.js',
        'plugins/fullcalendar/fullcalendar.js',
        'plugins/fullcalendar/lang/es.js',
        'plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js',
        'plugins/bootstrap-select/bootstrap-select.min.js',

    ];
    public $depends = [
        'app\assets\SystemAsset',
    ];
}