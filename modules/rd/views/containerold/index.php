<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\ContainerSearchOld */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contenedores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-index">

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

    <p>
        <?= Html::a('Nuevo Contenedor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'code',
            'tonnage',
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
    <?php Pjax::end(); ?>
        </div>
</div>
