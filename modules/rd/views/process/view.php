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
use app\modules\rd\models\Container;
use yii\helpers\Url;

use app\modules\rd\models\Process;

WizardAsset::register($this);
FormAsset::register($this);
TableAsset::register($this);

//$this->title = 'Rece'$model->bl;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Importaciones/Exportaciones'), 'url' => Url::to(['/site/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-inverse m-1" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
        </div>
        <h4 class="panel-title">Detalles del Proceso</h4>
    </div>
    <div class="panel-body m-1">
        <div class="row">
            <div class="col-md-3">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute'=>'id',
                            'label'=>'No.',
                        ],
                        'bl',
//                        [
//                            'class' => 'yii\grid\DataColumn',
//                            'attribute' => 'type',
//                            'value' =>  \app\modules\rd\models\Process::PROCESS_LABEL[$model->type]
//                        ],
//                        'delivery_date:datetime',
//                        'created_at:datetime',
//                        [
//                            'label'=>'Cantidad de Contenedores',
//                            'value'=>$model->getContainerAmount()
//                        ]
                    ],
//                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                    'options'=>['class' => 'table table-bordered table-condensed detail-view m-1 p-1'],
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'class' => 'yii\grid\DataColumn',
                            'attribute' => 'type',
                            'value' =>Process::PROCESS_LABEL[$model->type]
                        ],
                        'delivery_date:datetime',
                    ],
                    'options'=>['class' => 'table table-bordered table-condensed detail-view'],
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'created_at:datetime',
                        [
                            'label'=>'Cantidad de Contenedores',
                            'value'=>$model->getContainerAmount()
                        ]
                    ],
                    'options'=>['class' => 'table table-bordered table-condensed detail-view'],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'name',
                        [
                            'label' => "Tipo/Tamaño",
                            value  => function($data)
                            {
                                return $data['code'] . $data['tonnage'];
                            }
                        ],
                        //                                    'code',
                        //                                    'tonnage',
                        'status',
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>