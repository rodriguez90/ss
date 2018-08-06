<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */
/* @var $form yii\widgets\ActiveForm */

use app\modules\rd\models\Process;
use app\modules\rd\models\UserAgency;

use app\assets\FormAsset;
use app\assets\TableAsset;
use app\assets\WizardAsset;

WizardAsset::register($this);
FormAsset::register($this);
TableAsset::register($this);

$userAgency = UserAgency::findOne(['user_id'=>Yii::$app->user->getId()]);

$agency = null;

if($userAgency)
{
    $agency = $userAgency->agency;
}

$filterLabel = "";
$intVal = (int)$type;

if( $intVal === Process::PROCESS_IMPORT)
{
    $filterLabel = "Búsqueda por BL";
}
else if ($intVal === Process::PROCESS_EXPORT)
{
    $filterLabel = "Búsqueda por Booking";
}

?>
<style>
    .select2.select2-container.select2-container--default.select2-container--below
    {
        width: 100% !important;
    }
    .bwizard .well
    {
        padding: 0px 15px 0px 15px; !important;
    }
    #dialog-spinner
    {
        margin: 0px 0px 0px 0px; !important;
    }
    .fc-axis {
        height: 30px; !important;
    }

    /*.fc-widget-header*/
    /*{*/
        /*margin: 0px 0px 0px 0px; !important;*/
        /*padding: 0px 0px 0px 0px; !important;*/
    /*}*/

    /*table thead tr td.fc-head-container.fc-widget-header*/
    /*{*/
        /*!*display: none;: none; !important;*!*/

        /*padding: 0px 0px 0px 0px; !important;*/
    /*}*/

</style>

<div class="panel panel-inverse p-3">
    <div class="panel-heading p-5">
        <div class="panel-heading-btn">
        </div>
        <h4 class="panel-title"><?php echo 'Nueva '. Process::PROCESS_LABEL[$type]?></h4>
    </div>
    <div class="panel-body p-1">

        <div class="row m-1">
            <!-- begin from BL search-->
            <div class="col-md-4">
                <div class="panel panel-default m-1">
                    <div id="blCodeHeading" class="panel-heading p-2">
                        <h4 class="panel-title"><?php echo $filterLabel; ?></h4>
                    </div>
                    <div class="panel-body p-5">
                        <div class="row">
                            <div class="col col-md-9">
                                <input class="form-control" type="text" id="blCode" name="blCode" data-parsley-length="[5, 25]" data-parsley-focus="first" placeholder="Código"  data-parsley-trigger="focusin focusout" data-parsley-required="true"/>
                            </div>
                            <div class="col col-md-3">
                                <button id="search-container" class="btn btn-sm btn-primary" disabled>Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end BL search-->

            <!-- begin from line nav data-->
            <div class="col-md-3">
                <div class="panel panel-default m-1">
                    <div id="blCodeHeading" class="panel-heading p-2">
                        <h4 class="panel-title">Linea</h4>
                    </div>
                    <div class="panel-body p-5">
                        <div class="col col-md-12">
                            <div class="row">
                                <span id="oce" class="label label-info f-s-12">OCE: -</span>
                            </div>
                            <div class="row">
                                <span id="line" class="label label-info f-s-12">LINEA: -</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end line nav data-->
            <!-- begin wharehouse select-->
            <div class="col-md-2">
                <div class="panel panel-default  m-1">
                    <div id="blCodeHeading" class="panel-heading p-2">
                        <h4 class="panel-title">Depósito Destino</h4>
                    </div>
                    <div class="panel-body p-5">
                        <div class="row">
                            <select class="form-control" disabled>
                                <option>TPG</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end wharehouse select-->
            <!-- begin time-->
            <div class="col-md-3">
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
        <!-- begin row wizard-->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <form action="/" method="POST" data-parsley-validate="true" name="form-wizard">
                    <div id="wizard">
                        <ol>
                            <li> Seleccionar contenedores</li>
                            <li> Seleccionar compañia de transporte</li>
                            <li> Confirmar y notificar</li>
                        </ol>
                        <!-- begin wizard step-1 -->
                        <div class="wizard-step-1">
                            <fieldset>
                                <div class="col col-md-12">
                                    <!-- begin row -->
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table id="data-table" class="table table-bordered nowrap" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Seleccione <input type="checkbox" name="select_all" value="1" id="select-all"></th>
                                                    <th><?php echo $intVal == Process::PROCESS_IMPORT ? ' Contenedor': 'Booking/Contenedor'?></th>
                                                    <th>Tipo/Tamaño</th>
                                                    <th>Fecha Límite</th>
                                                    <th>Estado</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end row -->
                                    <div id="staticLinks" class="row" style="display: none;">
                                        <div class="col-md-8 col-md-offset-4">
                                            <a href="http://www.tpg.com.ec" >Solicitar crédito</a>
                                            <a href="http://www.tpg.com.ec" >Factura en línea</a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!-- end wizard step-1 -->
                        <!-- begin wizard step-2 -->
                        <div class="wizard-step-2">
                            <fieldset>
                                <!-- begin row -->
                                <div class="row">
                                    <div class="col col-sm-6">
                                        <div class="row">
                                            <h5 class="col col-md-8">¿Múltiples empresas de transporte?</h5>
                                            <div class="col col-md-2">
                                                <input type="radio" name="radio_default_inline" id="yesRadio" value="1" />
                                                <label for="defaultInlineRadio1">Si</label>
                                            </div>
                                            <div class="col col-md-2">
                                                <input type="radio" name="radio_default_inline" id="noRadio" value="0" checked/>
                                                <label for="defaultInlineRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" id="selectTransCompany"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-md-12">
                                        <div class="table-responsive">
                                            <table id="data-table3" class="table table-bordered nowrap" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Seleccione <input type="checkbox" name="select_all2" id="select_all2" value="1" ></th>
                                                    <th><?php echo $intVal == Process::PROCESS_IMPORT ? ' Contenedor': 'Booking/Contenedor'?></th>
                                                    <th>Tipo/Tamaño</th>
                                                    <th>Fecha Límite</th>
                                                    <th>Cliente</th>
                                                    <th>Empresa de Transporte</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <!-- end wizard step-2 -->
                        <!-- begin wizard step-3 -->
                        <div class="wizard-step-3">
<!--                            <fieldset>-->
                                <!-- begin row -->
                                <div class="alert alert-success fade in p-3 m-0">
                                    <!--                                                            <span class="close" data-dismiss="alert">×</span>-->
                                    <i class="fa fa-check fa-2x pull-left"></i>
                                    <p>Los contenedores y la compañia de transporte seleccionados se muestran a continuación, si está de acuerdo con los datos mostrados,
                                        confirme la información y finalice el proceso, de lo contrario regrese al punto que considere incorrecto y corrija la información.
                                    </p>
                                </div>
                                <!-- end row -->
                                <!-- begin row -->
                                <div class="row m-0 p-0">
                                    <div class="table-responsive">
                                        <table id="data-table2" class="table table-bordered nowrap" width="100%">
                                            <thead>
                                            <tr>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!-- end row -->
                                <!-- begin row -->
<!--                                <div class="row">-->
<!--                                    <div class="panel panel-default">-->
<!--                                        <div class="panel-heading p-2">-->
<!--                                            <h4 class="panel-title">Compañia de transporte</h4>-->
<!--                                        </div>-->
<!--                                        <div class="panel-body">-->
<!--                                            <h5><strong id="trans_company"> -- </strong></h5>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
                                    <div class="checkbox">
                                        <input id="confirming" type="checkbox" data-render="switchery" data-size="small" data-click="check-switchery-state" data-id="switchery-state" data-theme="blue"/>
                                        <span id="confLabel" class="label label-success f-s-12">Confirmar Información</span>
                                    </div>
<!--                                </div>-->
                                <!-- end row -->
<!--                            </fieldset>-->
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
<div class="modal fade" id="modal-select-bussy" role="dialog" data-backdrop='static'>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title">Proceso Completado</h4>
            </div>
            <div class="modal-body p-15">
                <div class="jumbotron m-b-0 text-center">
                    <span id="dialog-spinner" class="spinner"></span>
                    <p>Los datos de la nueva <?php echo Process::PROCESS_LABEL[$type]?> han sido enviados al TPG.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var agency = <?php echo json_encode(['name'=>$agency->name,
        'id'=>$agency->id  ]); ?>;
    var processType = '<?php echo $type;?>';
</script>

<?php $this->registerJsFile('@web/js/modules/rd/process/form-wizards-validation-create.js', ['depends' => ['app\assets\WizardAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/process/table-manage.js', ['depends' => ['app\assets\SystemAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/process/process-create.js', ['depends' => ['app\assets\SystemAsset', 'app\assets\FormAsset']]) ?>


