<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\ReceptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\modules\administracion\models\AdmUser;
$this->title = 'SGT';

//var_dump($this->params) ;die;
//var_dump($rol);die;
//echo $user;
//echo json_encode($user);
$user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
//var_dump($user);die;
$rol = $user->getRole();

//var_dump($rol);die;

?>

<div class="row">
    <!-- begin col-3 -->
<!--    <div class="col-md-3 col-sm-6">-->
<!--        <div class="widget widget-stats bg-green">-->
<!--            <div class="stats-icon"><i class="fa fa-cubes"></i></div>-->
<!--            <div class="stats-info">-->
<!--                <h4>CONTENEDORES</h4>-->
<!--                <p>3,291,922</p>-->
<!--            </div>-->
<!--            <div class="stats-link active">-->
<!--                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-in"></i></div>
            <div class="stats-info">
                <h4>RECEPCIONES</h4>
                <p><?php echo $receptionCount?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo \yii\helpers\Url::to('/rd/reception/create');?>">Realice una solocitud de recepción.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-out"></i></div>
            <div class="stats-info">
                <h4>DESPACHO</h4>
                <p>-</p>
            </div>
            <div class="stats-link">
                <a id="" href="javascript:;">Realice una solocitud de despacho.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

    <!-- begin col-3 -->
<!--    <div class="col-md-3 col-sm-6">-->
<!--        <div class="widget widget-stats bg-purple">-->
<!--            <div class="stats-icon"><i class="fa fa-building"></i></div>-->
<!--            <div class="stats-info">-->
<!--                <h4>DEPÓSITOS</h4>-->
<!--                <p>1,291,922</p>-->
<!--            </div>-->
<!--            <div class="stats-link">-->
<!--                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- end col-3 -->

    <!-- begin col-3 -->
<!--    <div class="col-md-3 col-sm-6">-->
<!--        <div class="widget widget-stats bg-red">-->
<!--            <div class="stats-icon"><i class="fa fa-ticket"></i></div>-->
<!--            <div class="stats-info">-->
<!--                <h4>CUPOS</h4>-->
<!--                <p>1,291,922</p>-->
<!--            </div>-->
<!--            <div class="stats-link">-->
<!--                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <div class="widget widget-stats bg-orange">
            <div class="stats-icon"><i class="fa fa-clock-o"></i></div>
            <div class="stats-info">
                <h4>REPORTES</h4>
                <p>Linea del tiempo</p>
            </div>
            <div class="stats-link">
                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->
</div>
<!-- end row -->

<!-- begin row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Solicitudes realizadas</h4>
            </div>

            <div id="panel-body" class="panel-body">
                <?php Pjax::begin(); ?>
<!--                --><?php //Pjax::end(); ?>
<!--                <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">-->
                    <?=
                        GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'id',
                                'label' => 'Número de recepción'
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'trans_company_id',
                                'value' => 'transCompany.name',
                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'agency_id',
                                'value' => 'agency.name',
                            ],
                            [
//                                'class' => 'yii\grid\DataColumn',
                                'attribute' => 'created_at',
                                'format' => 'date',
                            ],
//                            'created_at:datetime',
//                            [
//                                'class' => 'yii\grid\DataColumn',
//                                'attribute' => 'agency_id',
//                                'value' => 'agency.name'
//                            ],
                            [
                                'class' => 'yii\grid\DataColumn',
                                'label' => "Contenedores",
                                'attribute' => 'containerAmount'
                            ],
//                            [
//                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
//                                'label' => Yii::t('app', "Activo"),
//                                'attribute' => 'active',
//                                'value' => function ($data) {
//                                    $value = Yii::t('app', "No");
//                                    if($data->active)
//                                        $value = Yii::t('app', "Si");
//
//                                    return $value; // $data['name'] for array data, e.g. using SqlDataProvider.
//                                },
//                                'filter' => ['1' =>'Si' , '0'=>'No',],
//                            ],
                            [
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'label' => Yii::t('app', "Proceso"),
                                'value' => function($data) {
                                    return 'Recepción';
                                }
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'controller' => 'rd/reception',
                                'template' => '{view}',
//                                'urlCreator' =>
//                                'controller' =>Url::to(['rd/reception/trans-company/'], true),
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Acciones',
                                'template' => '{myButton}',  // the default buttons + your custom button
                                'buttons' => [
                                    'myButton' => function($url, $model, $key) {
                                        $result = '';
                                        if($rol === 'Agencia')
                                            $result = Html::a('Ver', ['site/index'], ['class' => 'btn btn-success btn-xs', 'data-pjax' => 0]);
                                        else if($rol === 'Cia_transporte')
                                            $result = Html::a('Turnos', ['site/index'], ['class' => 'btn btn-success btn-xs', 'data-pjax' => 0]);
//                                        var_dump($result);die;
                                        return $result;
                                    }
                                ]
                            ],
                    ]
                    ]); ?>
<!--                </table>-->
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
   $this->registerJsFile('@web/js/dashboard.js', ['depends' => ['app\assets\SystemAsset']]);
?>
