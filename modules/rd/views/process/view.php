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
use app\modules\rd\models\Container;
use yii\helpers\Url;

WizardAsset::register($this);
FormAsset::register($this);
TableAsset::register($this);

//$this->title = 'Rece'$model->bl;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Importaciones/Exportaciones'), 'url' => Url::to(['/site/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-inverse" data-sortable-id="ui-widget-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Detalles del Proceso</h4>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
//                       'id',
                        [
                            'attribute'=>'id',
                            'label'=>'No.',
                        ],
                        'bl',
                        [
                            'class' => 'yii\grid\DataColumn',
                            'attribute' => 'type',
                            'value' =>  \app\modules\rd\models\Process::PROCESS_LABEL[$model->type]
                        ],
                        'created_at:datetime',
//                        [
//                            'attribute'=>'transCompany',
//                            'value'=>$model->transCompany->name
//                        ],
//                        [
//                            'attribute'=>'agency',
//                            'value'=>$model->agency->name
//                        ],
//                        [
//                            'attribute'=>'active',
//                            'value'=>$model->active ? 'Si':'No'
//                        ],
                        [
                            'label'=>'Cantidad de Contenedores',
                            'value'=>count($model->receptionTransactions)
                        ]
                    ],
                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                ]) ?>
            </div>
        </div>
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!--                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
                            <!--                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>-->
                            <!--                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
                        </div>
                        <h2 class="panel-title">Contenedores</h2>
                    </div>
                    <div class="panel-body">
                        <?php
                            GridView::widget([
                                'dataProvider' => $containerDataProvider,
                                'filterModel' => $containersSearchModel,
                                'columns' => [
                                    'name',
                                    'code',
                                    'tonnage',
                                ],
                            ]);
//                        $result = Html::ul($containers, ['item' => function($item, $index) {
//                            $li = Html::tag(
//                                'li',
//                                Html::encode($item['name'] . ' '. $item['code'] . ' ' . $item['tonnage']),
//                                []
//                            );
//                            return $li;
//                        }]);
//                        echo $result;
                        ?>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
    </div>
</div>