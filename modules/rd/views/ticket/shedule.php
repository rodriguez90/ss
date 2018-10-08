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

    .fc-scroller.fc-time-grid-container{
        overflow:scroll scroll !important;
    }
    /*.fc-scroller.fc-time­grid-container { box-sizing: border-box !importan;}*/
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

<!-- #modal-containers -->
<div class="modal fade" id="modal-select-containers">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title"></h4>
                <h5 id="modalTicket" class="modal-title"></h5>
            </div>
            <div class="modal-body p-15">
                <div class="table-responsive">
                    <table id="data-table-modal" class="table table-striped table-bordered table-condensed nowrap" width="100%">
                        <thead>
                        <tr>
                            <th>Seleccione <input type="checkbox" name="select_all" value="1" id="select-all"></th>
                            <th>Contenedor</th>
                            <th>Tipo</th>
                            <th>Fecha Límite</th>
                            <th>Agencia</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Cancelar</a>
                <!--                <a id="aceptBtn" href="#;" class="btn btn-sm btn-success" disabled>Aceptar</a>-->
                <a id="aceptBtn" href="#;" class="btn btn-sm btn-success" >Aceptar</a>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var userId = '<?php echo $user->id; ?>';
</script>

<?php $this->registerJsFile('@web/js/modules/rd/ticket/shedule.js', ['depends' => ['app\assets\CalendarAsset', 'app\assets\TableAsset']]) ?>

