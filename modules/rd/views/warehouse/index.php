<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Depósitos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <div class="panel panel-inverse" data-sortable-id="index-1">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
            <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('app', 'Nuevo Depósito'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'code_oce',
                    'ruc',

                    [
                        'attribute' => 'active',
                        'format' => 'text',
                        'content' => function ($data)
                        {
                            return $data['active'] ? '<span class="label label-success pull-left">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'active', [
                            'activo' => 'Activo', 'inactivo' => 'Inactivo',
                        ], ['class' => 'form-control', 'prompt'=>''])
                    ],



                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            </div>
            <?php Pjax::end(); ?>
        </div>
</div>
