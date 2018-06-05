<?php

/* @var $this yii\web\View */

$this->title = 'SGT';
$option = 1;

use app\assets\TableAsset;
TableAsset::register($this);
?>

<div class="row">
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"><i class="fa fa-cubes"></i></div>
            <div class="stats-info">
                <h4>CONTENEDORES</h4>
                <p>3,291,922</p>
            </div>
            <div class="stats-link active">
                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-in"></i></div>
            <div class="stats-info">
                <h4>RECEPCIONES</h4>
                <p>20.44%</p>
            </div>
            <div class="stats-link">
                <a href="javascript:;">Realice una solocitud de recepción.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-out"></i></div>
            <div class="stats-info">
                <h4>DESPACHO</h4>
                <p>20.44%</p>
            </div>
            <div class="stats-link">
                <a id="" href="javascript:;">Realice una solocitud de despacho.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-purple">
            <div class="stats-icon"><i class="fa fa-building"></i></div>
            <div class="stats-info">
                <h4>DEPÓSITOS</h4>
                <p>1,291,922</p>
            </div>
            <div class="stats-link">
                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-ticket"></i></div>
            <div class="stats-info">
                <h4>CUPOS</h4>
                <p>1,291,922</p>
            </div>
            <div class="stats-link">
                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
            <div class="stats-info">
                <h4>REPORTES</h4>
                <p>1,291,922</p>
            </div>
            <div class="stats-link">
                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
</div>
<!-- end row -->

<!-- begin row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Solicitudes realizadas</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">

                </table>
            </div>
        </div>
    </div>
</div>

<?php
   $this->registerJsFile('@web/js/dashboard.js', ['depends' => ['app\assets\SystemAsset']]);
?>
