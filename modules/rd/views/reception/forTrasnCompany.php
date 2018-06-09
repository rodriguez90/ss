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
//                'id',
                       'bl',
                       'created_at:datetime',
//                [
//                        'attribute'=>'transCompany',
//                        'value'=>$model->transCompany->name
//                ],

                       [
                           'attribute'=>'agency',
                           'value'=>$model->agency->name
                       ],
                       [

                           'attribute'=>'active',
                           'value'=>$model->active ? 'Si':'No'

                       ]
                   ],
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
<!--                                                    <div class="vertical-box">-->
<!--                                                        <div data-scrollbar="true" data-height="280px">-->
    <!--                                                        <div class="vertical-box-column p-15 bg-silver width-sm">-->
    <!--                                                        <div class="vertical-box-column p-15 bg-silver width-sm">-->
                                                        <div class="col-md-3">

                                                            <div class="row">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" id="select-all-event" />
                                                                        Seleccionar
                                                                    </label>
                                                                </div>
                                                                <h4 class="m-b-20">Contenedores disponibles</h4>
                                                            </div>
                                                            <div id="external-events" class="calendar-event" data-scrollbar="true" data-height="300px">

                                                                <!--                                                                <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">-->
                                                                <!--                                                                    <thead>-->
                                                                <!--                                                                    <tr>-->
                                                                <!---->
                                                                <!--                                                                        <th>Seleccione <input type="checkbox" name="select_all" value="1" id="select-all"></th>-->
                                                                <!--                                                                        <th>Contenedores</th>-->
                                                                <!--                                                                        <th>Tipo</th>-->
                                                                <!--                                                                        <th>Fecha Límite</th>-->
                                                                <!--                                                                    </tr>-->
                                                                <!--                                                                    </thead>-->
                                                                <!--                                                                </table>-->
                                                                <?php

                                                                    foreach ($model->receptionTransactions as $receptionTransaction)
                                                                    {

                                                                        $container = $receptionTransaction->container;
                                                                        $data_title = $container->name; //. " " .$container->code;
                                                                        $color = '';
                                                                        $data_bg = '';
                                                                        $icon= 'fa fa-cubes';


                                                                        if($container->code === Container::DRY)
                                                                        {
                                                                            $color = 'bg-purple';
                                                                            $data_bg = 'bg-purple';

                                                                        }
                                                                        else if($container->code === Container::RRF)
                                                                        {
                                                                            $color = 'bg-blue';
                                                                            $data_bg = 'bg-blue';
                                                                        }


                                                                        $component = Html::beginTag('div', ['class'=>'external-event ' . $color,
                                                                                'data-bg'=>$data_bg,
                                                                                'data-title'=>$data_title,
                                                                                'data-media'=>Html::tag('i', '',  ['class'=>$icon]),
                                                                                'data-desc'=>$container->code,
                                                                                'data-id'=>$receptionTransaction->id,
                                                                            ])
                                                                            .Html::checkbox('checkBox'.$receptionTransaction->id, false, ['id'=>'checkBox'.$receptionTransaction->id])
                                                                            .Html::beginTag('h5')
                                                                            .Html::tag('i', '',  ['class'=>$icon . ' fa-lg fa-fw'])
                                                                            //                                                                                            . Html::tag('br')
                                                                            . Html::encode($container->name)
                                                                            . Html::tag('br')
                                                                            .Html::endTag('h5')
                                                                            .Html::tag('p', Html::encode($container->code . $container->tonnage) )
                                                                            .Html::endTag('div');

                                                                        echo $component;
                                                                    }

                                                                ?>

                                                            </div> <!-- events-->
                                                        </div>
                                                        <div id="calendar" class="col-md-9 p-15 calendar"></div>
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
                                                        <tr>
                                                            <th>Contenedores</th>
                                                            <th>Tipo</th>
                                                            <th>Fecha Límite</th>
                                                            <th>Agencia</th>
                                                            <th>Placa del Carro</th>
                                                            <th>Cédula del Chofer</th>
                                                        </tr>
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

<!---->
<?php $this->registerJsFile('@web/js/modules/rd/form-validation-trans-company.js', ['depends' => ['app\assets\WizardAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/table-manage-select.demo.js', ['depends' => ['app\assets\SystemAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/calendar.js', ['depends' => ['app\assets\CalendarAsset']]) ?>
<?php $this->registerJsFile('@web/js/modules/rd/reception-trans-company.js', ['depends' => ['app\assets\SystemAsset', 'app\assets\FormAsset']]) ?>

