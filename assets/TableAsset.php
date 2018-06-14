<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 29/05/2018
 * Time: 1:49
 */

namespace app\assets;
use yii\web\AssetBundle;



class TableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
	'plugins/DataTables/media/css/dataTables.bootstrap.min.css',
    'plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css',
	'plugins/DataTables/extensions/Select/css/select.bootstrap.min.css',
	'plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css'	,
    'plugins/DataTables/extensions/KeyTable/css/keyTable.bootstrap.min.css',
    ];

    public $js = [
	'plugins/DataTables/media/js/jquery.dataTables.js',
	'plugins/DataTables/media/js/dataTables.bootstrap.min.js',
    'plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js',
    'plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js',
    'plugins/DataTables/extensions/Buttons/js/buttons.print.min.js',
    'plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js',
    'plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js',
    'plugins/DataTables/extensions/Buttons/js/buttons.colvis.min.js',
	'plugins/DataTables/extensions/Select/js/dataTables.select.min.js',
    'plugins/DataTables/extensions/KeyTable/js/dataTables.keyTable.min.js',
	'plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js',
    'plugins/DataTables/extensions/CellEdit/js/dataTables.cellEdit.js',
    'plugins/fullcalendar/lib/moment.min.js',
    ];

    public $depends = [
        'app\assets\SystemAsset',
    ];
}