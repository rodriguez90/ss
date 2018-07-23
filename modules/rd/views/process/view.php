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
<style>
    .detalle td, .detalle th, .detalle tr, .detalle tbody, table.detalle{
        border: 0px !important;
    }
</style>

<div class="panel panel-inverse m-1" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a id="print-process" href="<?= Url::to(['/rd/process/print?id='.$model->id]) ?>" style="color: white;font-size: 14px;" title="Exportar PDF" > <i class="fa fa-file-pdf-o"></i></a>
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
                        [
                            'attribute'=>'bl',
                            'label'=> $model->type === Process::PROCESS_IMPORT ? "BL":"Booking",
                        ],
                    ],
                    'options'=>['class' => 'table table-bordered table-condensed detail-view m-1 p-1 detalle'],
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
                        'delivery_date:date',
//                        [
//                            'attribute' => 'delivery_date',
//                            'label' => 'Fecha de Límite',
////                            'value'=>function ($data) {
////                                return (new \yii\i18n\Formatter())->asDate($data, 'd/m/Y');
////                            },
//                            'content' => function ($data) {
//                                return (new \yii\i18n\Formatter())->asDate($data);
//                            },
//                        ],
                    ],
                    'options'=>['class' => 'table table-condensed detalle'],
                ]) ?>
            </div>
            <div class="col-md-5">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'created_at:date',
                        [
                            'label'=>'Cantidad de Contenedores',
                            'value'=>$model->getContainerAmount()
                        ]
                    ],
                    'options'=>['class' => 'table detail-view detalle'],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
//                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'class' => 'yii\grid\DataColumn',
                            'label' => "Nombre",
                            'attribute' => 'container_id',
                            'value' => 'container.name',
                        ],
                        [
                            'class' => 'yii\grid\DataColumn',
                            'label' => "Tipo/Tamaño",
                            'attribute' => 'container_id',
                            'value'  => function($data)
                            {
                                return $data->container->code . $data->container->tonnage;
                            },
                        ],
                        'status',
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>