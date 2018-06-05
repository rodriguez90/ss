<?php

use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;



/* @var $this yii\web\View */
/* @var $searchModel app\modules\administracion\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <p>
        <?= Html::a('Nuevo Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>


<div class="row">
<!-- begin col-12 -->
<div class="col-md-12 ui-sortable">
<!-- begin panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                    class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i
                    class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
               data-click="panel-collapse"><i class="fa fa-minus"></i></a>

        </div>
        <h4 class="panel-title">Lista de usuarios</h4>

    </div>
    <div class="panel-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" id="data-table_wrapper">

            <?php
            /*
            $gridColumns = [
               // ['class' => 'yii\grid\SerialColumn'],
                'username',
                'nombre',
                'apellidos',
                'publish_date',
                'email',
               // ['class' => 'yii\grid\ActionColumn'],
            ];
*/
            ?>


            <?php
            /*
            ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns
            ])

            */ ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'username',
                    'nombre',
                    'apellidos',
                    'email',



                    [
                        'attribute' => 'status',
                        'format' => 'text',
                        'content' => function ($data)
                            {
                                return $data->status ? '<span class="label label-success pull-left">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
                            },
                        'filter' => Html::activeDropDownList($searchModel, 'status', [
                                'activo' => 'Activo', 'inactivo' => 'Inactivo',
                            ], ['class' => 'form-control', 'prompt'=>''])
                    ],


                    //'password',
                    //'authKey',
                    //'accessToken',
                    //'status',
                    //'created_at',
                    //'email:email',
                    //'token_usuario',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            </div>
        </div>
    </div>
</div>





