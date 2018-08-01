<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\rd\models\Process;
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
                        'attribute' => 'process_transaction_id',
                        'value' => 'processTransaction.container.type.name',
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'label'=>'Fecha del Turno',
                        'attribute' => 'calendar_id',
                        'format' => 'datetime',
                        'value' => 'calendar.start_datetime',
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
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>
