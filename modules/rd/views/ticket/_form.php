<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Process */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;
use app\assets\TableAsset;
use app\assets\WizardAsset;
use \app\modules\rd\models\Container;

WizardAsset::register($this);
FormAsset::register($this);
TableAsset::register($this);

$user = \app\modules\administracion\models\AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
$trasCompany = null;

if($user)
{
    $trasCompany = $user->getTransCompany();
}

?>
<style>
    .fc-time-grid .fc-slats td
    {
        height: 2.0em !important;
    }
    .fc-title {
        font-size: 16px !important;
    }
    /*.bwizard .well*/
    /*{*/
        /*padding: 0px 15px 0px 15px; !important;*/
    /*}*/
    .detalle td, .detalle th, .detalle tr, .detalle tbody, table.detalle{
        border: 0px !important;
    }

</style>

<div class="panel panel-inverse p-3"">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
        <h4 class="panel-title">Asignación de Cupos:  <?php echo $model->type == \app\modules\rd\models\Process::PROCESS_IMPORT ? "Importación" : "Exportación"?></h4>
    </div>
    <div class="panel-body">

        <div class="row m-1">
           <div class="col-md-4">
               <?= DetailView::widget([
                   'model' => $model,
                   'attributes' => [
                       [
                           'attribute'=>'bl',
                           'label'=>$model->type == \app\modules\rd\models\Process::PROCESS_IMPORT ? "BL" : "Booking"
                       ],
                       'delivery_date:date',
                   ],
                   'options'=>['class' => 'table table-condensed detail-view detalle'],
               ]) ?>
           </div>
            <div class="col-md-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute'=>'agency_id',
                            'value'=>$model->agency->name
                        ],
                        [
                            'label'=>'Cantidad de Contenedores',
                            'value'=>function($model){
                                $user = \app\modules\administracion\models\AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
                                if($user) // FIXME: CHECK to Administration Role
                                {
                                    $trasCompany = $user->getTransCompany();
                                    if($trasCompany)
                                        return count($model->getProcessTransactionsByTransCompany($trasCompany->id));
                                    else
                                        return 0;
                                }
                            }
                        ]
                    ],
                    'options'=>['class' => 'table table-condensed detail-view detalle'],
                ]) ?>
            </div>
            <!-- begin time-->
            <div class="col-md-4">
                <div id="stop_watch_widget" class="widget widget-stats bg-green p-5">
                    <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
                    <div class="stats-info">
                        <h4>Tiempo Disponible</h4>
                        <p id="stop_watch">00:29:59</p>
                    </div>
                </div>
            </div>
            <!-- end time-->
        </div>

        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <form action="/" method="POST" data-parsley-validate="true" name="form-wizard">
                    <div id="wizard">
                        <ol>
                            <li> Reservar Cupos</li>
                            <li> Transporte</li>
                            <li> Confirmar y Notificar</li>
                        </ol>
                        <!-- begin wizard step-1 -->
                        <div class="wizard-step-1">
                            <fieldset>
                                <!-- begin row -->
<!--                                <div class="row">-->
                                    <!-- begin panel -->
                                    <div class="panel panel-default">
                                        <div class="panel-body p-0">
<!--                                            <div class="vertical-box">-->
<!--                                                <div class="vertical-box-column p-15 bg-silver width-sm">-->
<!--                                                    <div id="external-events" class="calendar-event">-->
<!--                                                        <div class="external-event bg-blue-darker ui-draggable" style="position: relative;">-->
<!--                                                            <p class="f-s-14">Disponibilidad en el calendario.</p>-->
<!--                                                        </div>-->
<!--                                                        <div class="external-event bg-green-darker ui-draggable" style="position: relative;">-->
<!--                                                            <p class="f-s-14">Contenedores de 20 toneledas.</p>-->
<!--                                                        </div>-->
<!--                                                        <div class="external-event bg-purple-darker ui-draggable" style="position: relative;">-->
<!--                                                            <p class="f-s-14">Contenedores de 40 toneledas.</p>-->
<!--                                                        </div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div id="calendar" class="vertical-box-column p-15 calendar"></div>-->
<!--                                            </div>-->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <h4 class="m-b-20">Leyenda</h4>
                                                    <div class="external-event bg-blue-darker ui-draggable" style="position: relative;">
                                                        <p class="f-s-14">Cupos disponibles en el calendario.</p>
                                                    </div>
                                                    <div class="external-event bg-green-darker ui-draggable" style="position: relative;">
                                                        <p class="f-s-14">Cupos contenedores de 20 toneledas.</p>
                                                    </div>
                                                    <div class="external-event bg-purple-darker ui-draggable" style="position: relative;">
                                                        <p class="f-s-14">Cupos contenedores de 40 toneledas.</p>
                                                    </div>
                                                </div>
                                                <div id="calendar" class="col-md-10 p-15 calendar"></div>
                                            </div>

                                        </div> <!-- end panel body-->
                                    </div>
                                    <!-- end panel -->
<!--                                </div>-->
                                <!-- end row -->
                            </fieldset>
                        </div>
                        <!-- end wizard step-1 -->
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                            <fieldset>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-heading-btn">
                                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                            </div>
                                            <h4 class="panel-title">Contenedores seleccionados</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="data-table2" class="table table-striped table-bordered nowrap" width="100%">
                                                    <thead>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </fieldset>
                        </div>
                        <!-- end wizard step-2 -->
                        <!-- begin wizard step-3 -->
                        <div class="wizard-step-3">
                            <fieldset>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="alert alert-success fade in">
                                        <i class="fa fa-check fa-2x pull-left"></i>
                                        <p>Los datos de los cupos que serán reservados para los contenedores seleccionados se muestran a continuación, si está de acuerdo con la
                                            confirme la información y finalice el proceso, de lo contrario regrese al punto que considere incorrecto y corrija la información.
                                        </p>
                                    </div>
                                </div>
                                <!-- end row -->
                                <!-- begin row -->
                                <div class="row">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-heading-btn">
                                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                            </div>
                                            <h4 class="panel-title">Cupos a reservar</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="data-table3" class="table table-striped table-bordered nowrap" width="100%">
                                                    <thead>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row">
                                    <div class="checkbox">
                                        <label>
                                            <input id="confirming" type="checkbox"> Confirmar Información
                                        </label>
                                    </div>
                                </div>
                                <!-- end row -->
                            </fieldset>
                        </div>
                        <!-- end wizard step-3 -->
                        <!-- begin wizard step-4 -->
                        <div>
                            <div class="jumbotron m-b-0 text-center">
                                <h1>Proceso Completado</h1>
                                <p>Los datos han sido enviados al servidor.</p>
                            </div>
                        </div>
                        <!-- end wizard step-4 -->
                    </div>
                </form>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row wizard-->
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
    var modelId = '<?php echo $model->id; ?>';
    var transCompanyId = '<?php echo $trasCompany->id; ?>';
    var transCompanyRuc = '<?php echo $trasCompany->ruc; ?>';
//    var complex = <?php //echo json_encode($complex); ?>//;
</script>

<!---->
<?php $this->registerJsFile('@web/js/modules/rd/ticket/form-wizar-validation-create.js', ['depends' => ['app\assets\WizardAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/ticket/calendar.js', ['depends' => ['app\assets\CalendarAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/ticket/ticket-create.js', ['depends' => ['app\assets\SystemAsset', 'app\assets\FormAsset']]) ?>

