<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;
use app\assets\TableAsset;
use app\assets\WizardAsset;
use \app\modules\rd\models\Container;

WizardAsset::register($this);
FormAsset::register($this);
TableAsset::register($this);

?>
<style>
    .select2.select2-container.select2-container--default.select2-container--below
    {
        width: 100% !important;
    }
    .fc-time-grid .fc-slats td
    {
        height:2.5em !important;
    }
    .fc-title {
        font-size: 16px !important;
    }
    .bwizard .well
    {
        padding: 0px 15px 0px 15px; !important;
    }
</style>

<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Detalles de la Recepción</h4>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
//                       'id',
                        [
                            'attribute'=>'id',
                            'label'=>'No.',
                        ],
                        'bl',
                        'created_at:datetime',
                        [
                            'attribute'=>'transCompany',
                            'value'=>$model->transCompany->name
                        ],
                        [
                            'attribute'=>'agency',
                            'value'=>$model->agency->name
                        ],
                        [
                            'attribute'=>'active',
                            'value'=>$model->active ? 'Si':'No'
                        ],
                        [
                            'label'=>'Cantidad de Contenedores',
                            'value'=>count($model->receptionTransactions)
                        ]
                    ],
                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                ]) ?>
            </div>

            <!-- begin time-->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Tiempo Disponible</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <!--                                        <div class="stats-info">-->
                            <!--                                            <p>00:12:23</p>-->
                            <!--                                        </div>-->

                            <div class="col-md-2">
                                <h5 id="hours">00</h5>
                                <h5>Horas</h5>
                            </div>
                            <div class="col-md-2">
                                <h5 id="minutes">29</h5>
                                <h5>Minutos</h5>
                            </div>
                            <div class="col-md-2">
                                <h5 id="seconds">59</h5>
                                <h5>Segundos</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end time-->
        </div>

        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                        <h2 class="panel-title">Datos a Intoducir</h2>
                    </div>
                    <div class="panel-body">
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
                                        <div class="row">
                                            <!-- begin panel -->
                                            <div class="panel panel-default col-sm-12">
                                                <!--                                                <div class="panel-heading">-->
                                                <!--                                                    <div class="panel-heading-btn">-->
                                                <!--                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
                                                <!--                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>-->
                                                <!--                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
                                                <!--                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>-->
                                                <!--                                                    </div>-->
                                                <!--                                                    <h4 class="panel-title">Calendario</h4>-->
                                                <!--                                                </div>-->
                                                <div class="panel-body p-5">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <h4 class="m-b-20">Leyenda</h4>
                                                            <div class="external-event bg-blue ui-draggable" style="position: relative;">
                                                                <p>Disponibilidad en el calendario.</p>
                                                            </div>
                                                            <div class="external-event bg-green ui-draggable" style="position: relative;">
                                                                <p>Contenedores de 20 toneledas.</p>
                                                            </div>
                                                            <div class="external-event bg-purple ui-draggable" style="position: relative;">
                                                                <p>Contenedores de 40 toneledas.</p>
                                                            </div>
                                                        </div>
                                                        <div id="calendar" class="col-md-10 p-15 calendar"></div>
                                                    </div>

                                                </div> <!-- end panel body-->
                                            </div>
                                            <!-- end panel -->
                                        </div>
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
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                    <h4 class="panel-title">Contenedores seleccionados</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table id="data-table2" class="table table-striped table-bordered nowrap" width="100%">
                                                        <thead>
                                                        </thead>
                                                    </table>
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
                                        <!--                                                    <legend class="pull-left width-full">Confirmar y notificar </legend>-->
                                        <!-- begin row -->
                                        <div class="row">
                                            <div class="alert alert-success fade in">
                                                <!--                                                            <span class="close" data-dismiss="alert">×</span>-->
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
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                    <h4 class="panel-title">Cupos a reservar</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table id="data-table3" class="table table-striped table-bordered nowrap" width="100%">
                                                        <thead>
                                                        </thead>
                                                    </table>
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
                                        <!--                                                    <p><a class="btn btn-success btn-lg" role="button"></a> </p>-->
                                    </div>
                                </div>
                                <!-- end wizard step-4 -->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row wizard-->
    </div>
</div>



<!-- #modal-alert -->
<div class="modal fade" id="modal-select-containers">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title"></h4>
                <h5 id="modalTicket" class="modal-title"></h5>
            </div>
            <div class="modal-body p-15">
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
    //    var complex = <?php //echo json_encode($complex); ?>//;
</script>

<!---->
<?php $this->registerJsFile('@web/js/modules/rd/ticket/form-wizar-validation-create.js', ['depends' => ['app\assets\WizardAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/ticket/calendar.js', ['depends' => ['app\assets\CalendarAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/ticket/ticket-create.js', ['depends' => ['app\assets\SystemAsset', 'app\assets\FormAsset']]) ?>

