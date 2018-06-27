<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

use \app\modules\rd\models\Container;

$this->title = Yii::t('app', 'Calendario de Cupos');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cupos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .fc-time-grid .fc-slats td
    {
        height: 2.5em !important;
    }
    .fc-title {
        font-size: 16px !important;
    }
    .detalle td, .detalle th, .detalle tr, .detalle tbody, table.detalle{
        border: 0px !important;
    }
</style>

<div class="panel panel-inverse p-3"">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
        <h4 class="panel-title">Mi Calendario</h4>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="row">
                <div class="col-md-2">
                    <h4 class="m-b-20">Leyenda</h4>
                    <div class="external-event bg-green-darker ui-draggable" style="position: relative;">
                        <p class="f-s-14">Contenedores de 20 toneledas.</p>
                    </div>
                    <div class="external-event bg-purple-darker ui-draggable" style="position: relative;">
                        <p class="f-s-14">Contenedores de 40 toneledas.</p>
                    </div>
                </div>
<!--                <div id="calendar" class="col-md-10 p-15 calendar"></div>-->
                <div id="calendar" class="vertical-box-column p-15 calendar fc fc-ltr"></div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var userId = '<?php echo $user->id; ?>';
</script>

<?php $this->registerJsFile('@web/js/modules/rd/ticket/shedule.js', ['depends' => ['app\assets\CalendarAsset']]) ?>

