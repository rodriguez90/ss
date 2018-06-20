<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;
use app\assets\TableAsset;
use app\assets\WizardAsset;

WizardAsset::register($this);
FormAsset::register($this);
TableAsset::register($this);
?>
<style>
    .select2.select2-container.select2-container--default.select2-container--below
    {
        width: 100% !important;
    }
</style>

<div class="panel panel-inverse p-3" data-sortable-id="ui-widget-1">
    <div class="panel-heading p-5">
        <div class="panel-heading-btn">
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
        </div>
        <h4 class="panel-title">Nueva Importación</h4>
    </div>
    <div class="panel-body p-1">

        <div class="row m-1">
            <!-- begin from BL search-->
            <div class="col-md-4">
                <div class="panel panel-default m-1">
                    <div id="blCodeHeading" class="panel-heading p-2">
                        <h4 class="panel-title">Búsqueda por BL</h4>
                    </div>
                    <div class="panel-body p-5">
                        <div class="row">
                            <div class="col col-md-9">
                                <input class="form-control" type="text" id="blCode" name="blCode" data-parsley-errors-container="#alert-widget" data-parsley-length="[5, 25]" data-parsley-focus="first" placeholder="Código"  data-parsley-trigger="focusin focusout" data-parsley-required="true"/>
                            </div>
                            <div class="col col-md-3">
                                <button id="search-container" class="btn btn-sm btn-primary" disabled>Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end BL search-->
            <!-- begin wharehouse select-->
            <div class="col-md-4">
                <div class="panel panel-default">
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
        <!-- begin row wizard-->
        <div class="row m-1">
            <!-- begin col-12 -->
            <div class="col-md-12 m-0">
                <form action="/" method="POST" data-parsley-validate="true" name="form-wizard">
                    <div id="wizard" class="m-0">
                        <ol>
                            <li> Seleccionar contenedores</li>
                            <li> Seleccionar compañia de transporte</li>
                            <li> Confirmar y notificar</li>
                        </ol>
                        <!-- begin wizard step-1 -->
                        <div class="wizard-step-1">
                            <fieldset>
                                <!-- begin row -->
                                <div class="row">
                                    <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Seleccione <input type="checkbox" name="select_all" value="1" id="select-all"></th>
                                            <th>Contenedores</th>
                                            <th>Tipo/Tamaño</th>
                                            <th>Fecha Límite</th>
                                            <th>Cliente</th>
                                        </tr>
                                        </thead>
                                    </table>
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
                                        <div class="panel-body">
                                                <div class="row">
                                                    <div class="col col-md-12">
                                                            <label class="col-md-3 col-form-label">¿Múltiples empresas de transporte?</label>
                                                            <input type="radio" name="radio_default_inline" id="yesRadio" value="1"/>
                                                            <label for="defaultInlineRadio1">Si</label>
                                                            <input type="radio" name="radio_default_inline" id="noRadio" value="0" checked/>
                                                            <label for="defaultInlineRadio2">No</label>
                                                    </div>
                                                </div>
                                                <div id="tContainer" class="row">
                                                    <div id="tSingle" class="col col-md-12">
                                                        <div class="col-md-5">
                                                            <select class="form-control" id="select-agency"  class="form-control"/>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <h5>Información de la Compañia de Transporte</h5>
                                                        </div>
                                                    </div>
                                                    <div id="tMultiple" class="col col-md-12" style="display: none;">
                                                        <table id="data-table3" class="table table-striped table-bordered nowrap" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th>Contenedores</th>
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
                                    <table id="data-table2" class="table table-striped table-bordered nowrap" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Contenedores</th>
                                            <th>Tipo/Tamaño</th>
                                            <th>Fecha Límite</th>
                                            <th>Cliente</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <!-- end row -->
                                <!-- begin row -->
<!--                                <div class="row">-->
                                    <div class="panel panel-default">
                                        <div class="panel-heading p-2">
                                            <h4 class="panel-title">Compañia de transporte</h4>
                                        </div>
                                        <div class="panel-body">
                                            <h5><strong id="trans_company"> -- </strong></h5>
                                        </div>
                                    </div>
<!--                                </div>-->
<!--                                <div class="row p-0 m-auto">-->
                                    <div class="checkbox">
                                        <label>
                                            <input id="confirming" type="checkbox"> Confirmar Información
                                        </label>
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

<?php $this->registerJsFile('@web/js/modules/rd/process/form-wizards-validation-create.js', ['depends' => ['app\assets\WizardAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/process/table-manage.js', ['depends' => ['app\assets\SystemAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/process/process-create.js', ['depends' => ['app\assets\SystemAsset', 'app\assets\FormAsset']]) ?>

