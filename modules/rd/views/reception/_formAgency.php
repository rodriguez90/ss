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

<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Recepción</h4>
    </div>
    <div class="panel-body">

        <div class="row">
            <!-- begin from BL search-->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Búsqueda por código BL</h4>
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="row">
                                <div class="col col-md-10">
                                    <input class="form-control" type="text" id="blCode" name="blCode"  data-parsley-type="alphanum"  data-parsley-length="[25, 25]" data-parsley-focus="first" placeholder="Código"  data-parsley-trigger="keyup" data-parsley-required="true"/>
<!--                                                <input type="text" class="form-control" id="blCode" placeholder="Código" />-->
                                </div>
                                <div class="col col-md-2">
                                    <button id="search-container" class="btn btn-sm btn-primary" disabled>Buscar</button>
                                </div>
                            </div>
                        </div>
<!--                                    <form class="form-inline" action="/" method="POST">-->
<!--                                        <div class="form-group m-r-10">-->
<!--                                            <input type="text" class="form-control" id="blCode" placeholder="Código" />-->
<!--                                        </div>-->
<!--                                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Buscar</button>-->
<!--                                    </form>-->
                    </div>
                </div>
            </div>
            <!-- end from BL search-->

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
                                <h5 id="minutes">30</h5>
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
            <!--        <div class="form-group">-->
            <label class="col-md-2 control-label">Depósito destino:</label>
            <div class="col-md-10">
                <select class="form-control" disabled>
                    <option>TPG</option>
                </select>
            </div>
            <!--        </div>-->
        </div>

        <br/>
        <!-- begin row wizard-->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <!--                                    <div class="panel-heading-btn">-->
                        <!--                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
                        <!--                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>-->
                        <!--                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
                        <!--                                    </div>-->
                        <!--                                    <h4 class="panel-title">Proceso de Recepción</h4>-->
                    </div>
                    <div class="panel-body">
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
                                        <!-- begin row -->
                                        <div class="row">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <div class="panel-heading-btn">
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                    <h4 class="panel-title">Listados de contenedores disponibles</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                                                        <thead>
                                                        <tr>

                                                            <th>Seleccione <input type="checkbox" name="select_all" value="1" id="select-all"></th>
                                                            <th>Contenedores</th>
                                                            <th>Tipo</th>
                                                            <th>Fecha Límite</th>
                                                            <th>Agencia</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
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
                                                <!--                                                                <div class="panel-heading">-->
                                                <!--                                                                    <h4 class="panel-title">Búsqueda por código BL</h4>-->
                                                <!--                                                                </div>-->
                                                <div class="panel-body">

                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <select class="form-control" id="select-agency"  class="form-control"/>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <h5>Información de la Compañia de Transporte</h5>
                                                        </div>
<!--                                                                    <div class="form-group">-->
<!---->
<!--                                                                       -->
<!--                                                                    </div>-->
<!--                                                                    <div class="col col-md-2">-->
<!--                                                                        <button id="search-agency" class="btn btn-sm btn-primary">Buscar</button>-->
<!--                                                                    </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                <p>Los contenedores y la compañia de transporte seleccionados se muestran a continuación, si está de acuerdo con los datos mostrados,
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
                                                    <h4 class="panel-title">Contenedores seleccionados</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <table id="data-table2" class="table table-striped table-bordered nowrap" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Contenedores</th>
                                                            <th>Tipo</th>
                                                            <th>Fecha Límite</th>
                                                            <th>Agencia</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->

                                        <!-- begin row -->
                                        <div class="row">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">Compañia de transporte</h4>
                                                </div>
                                                <div class="panel-body">
                                                    <!--                                                                <label class="label label-default"> Xedrux</label>-->
                                                    <h5><strong id="trans_company"> -- </strong></h5>
                                                </div>
                                            </div>
                                        </div>

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


<?php $this->registerJsFile('@web/js/modules/rd/form-wizards-validation-to-agency.demo.js', ['depends' => ['app\assets\WizardAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/table-manage-select.demo.js', ['depends' => ['app\assets\SystemAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/reception-agency.js', ['depends' => ['app\assets\SystemAsset', 'app\assets\FormAsset']]) ?>

