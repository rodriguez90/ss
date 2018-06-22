<?php


use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\widgets\Pjax;



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

                <?php Pjax::begin(); ?>

                <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" id="data-table_wrapper">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],
                            //'id',
                            'username',
                            'nombre',
                            'apellidos',
                            'email',

                            [
                                'attribute' => 'created_at',
                                'label' => 'Fecha de Creación',
                                'format' => 'html',// 'date',//date,datetime, time
                                'headerOptions' => ['width' => '120'],

                                'content' => function ($data) {
                                    return '<span class="fa fa-calendar">&nbsp;' . (new \yii\i18n\Formatter())->asDate($data->getCreate(), 'Y-MM-dd') . '</span>';
                                },
                                /*
                                'filter' => yii\jui\DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'value'=>'created_at',
                                    'language' => 'es',
                                    'dateFormat' => 'php:Y-m-d',
                                    'clientOptions' => [
                                        'prevText' => '<i style="cursor: pointer" class="fa fa-chevron-left"></i>',
                                        'nextText' => '<i style="cursor: pointer" class="fa fa-chevron-right"></i>',
                                    ]
                                ])*/
                            ],


                            'item_name',

                            [
                                'attribute' => 'status',
                                'format' => 'text',
                                'content' => function ($data) {
                                    return $data['status'] ? '<span class="label label-success pull-left">Activo</span>' : '<span class="label label-danger">Inactivo</span>';
                                },
                                'filter' => Html::activeDropDownList($searchModel, 'status', [
                                    'activo' => 'Activo', 'inactivo' => 'Inactivo',
                                ], ['class' => 'form-control', 'prompt' => ''])
                            ],


                            ['class' => 'yii\grid\ActionColumn' ],
                        ],


                    ]); ?>

                </div>

                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>





