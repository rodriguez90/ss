<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\rd\models\Process;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Turnos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <div class="panel panel-inverse" data-sortable-id="index-1">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
            <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="panel-body">

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'process_transaction_id',
                                'value' => 'processTransaction.container.name',
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'label' => 'Tipo',
                                'attribute' => 'containerType',
                                'value' => 'processTransaction.container.type.name',
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'label'=>'Fecha del Turno',
                                'attribute' => 'dateTimeTicket',
                                'format' => 'datetime',
                                'value' => 'calendar.start_datetime',
                                'filter' => \yii\jui\DatePicker::widget([
                                    'options' => ['class' => 'form-control'],
                                    'model' => $searchModel,
                                    'attribute' => 'dateTimeTicket',
                                    'language' => 'es',
//                                    'dateFormat' => 'php:d/m/Y',
                                    'dateFormat' => 'dd-MM-yyyy H:mm:s',
                                    'clientOptions' => [
                                        'prevText' => '<i style="cursor: pointer" class="fa fa-chevron-left"></i>',
                                        'nextText' => '<i style="cursor: pointer" class="fa fa-chevron-right"></i>',
                                    ]
                                ]),
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'label'=>'Placa del Carro',
                                'attribute' => 'register_truck',
                                'value' => 'processTransaction.register_truck',
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'label'=>'Chofer',
                                'attribute' => 'name_driver',
                                'value' => 'processTransaction.name_driver',
                                'format' => function($data)
                                {
                                    return utf8_encode($data);
                                }
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'label'=>'Ruc Chofer',
                                'attribute' => 'register_driver',
                                'value' => 'processTransaction.register_driver',
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'text',
                                'content' => function ($data)
                                {
                                    return $data['status'] ? '<span class="label label-success">Activo</span>' : '<span class="label label-danger">Consumido</span>';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'active', [
                                    '1' => 'Activo', '0' => 'Consumido',
                                ], ['class' => 'form-control', 'prompt'=>''])
                            ],
                            [
                                'label' => 'Proceso',
                                'attribute' => 'processType',
                                'value'=>'processTransaction.process.type',
                                'format' => function($data)
                                {
                                    return Process::PROCESS_LABEL[$data];
                                },
                                'filter' => ['1' =>'Importación' , '2'=>'Exportación',],
                            ],
        //                    'created_at',
        //                    ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
