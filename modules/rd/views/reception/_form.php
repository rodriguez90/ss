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

<div class="reception-form">

    <div class="row">
        <!--        begin panel conten-->
        <div class="col-md-12">
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

                                    <form class="form-inline" action="/" method="POST">
                                        <div class="form-group m-r-10">
                                            <input type="text" class="form-control" id="blCode" placeholder="Código" />
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Buscar</button>
                                    </form>
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
                                        <div class="col-md-2">
                                            <h5>00</h5>
                                            <h5>Horas</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>00</h5>
                                            <h5>Minutos</h5>
                                        </div>
                                        <div class="col-md-2">
                                            <h5>00</h5>
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
                            <select class="form-control">
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
                                                                        <th>Seleccionar</th>
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
                                                        <!-- begin from BL search-->
                                                        <div class="col-md-6">
                                                            <div class="panel panel-default">
<!--                                                                <div class="panel-heading">-->
<!--                                                                    <h4 class="panel-title">Búsqueda por código BL</h4>-->
<!--                                                                </div>-->
                                                                <div class="panel-body">

                                                                    <form class="form-inline" action="/" method="POST">
                                                                        <div class="form-group m-r-10">
                                                                            <input type="text" class="form-control" id="companyName" placeholder="Compañia de Transporte" />
                                                                        </div>
                                                                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Buscar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end from BL search-->
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
                                                                <h5><strong>Xedrux </strong></h5>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox"> Confirmar y notificar
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- end row -->
                                                </fieldset>
                                            </div>
                                            <!-- end wizard step-3 -->
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
        </div>
        <!-- end panel conten-->
    </div>
</div>

<?php $this->registerJsFile('@web/js/form-wizards-validation-to-agency.demo.js', ['depends' => ['app\assets\WizardAsset']]) ?>

