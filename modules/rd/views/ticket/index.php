<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\rd\models\Process;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Turnos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <div class="panel panel-inverse" data-sortable-id="index-1">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="panel-body">

            <?php Pjax::begin(); ?>
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                    </table>
                </div>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>

<?php $this->registerJsFile('@web/js/modules/rd/ticket/index.js', ['depends' => ['app\assets\TableAsset']]); ?>