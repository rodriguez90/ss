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
use app\modules\administracion\models\AuthItem;
$this->title = 'SGT';

//var_dump($this->params) ;die;
//var_dump($rol);die;
//echo $user;
//echo json_encode($user);

//var_dump($rol);die;


$user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
$rol = '';
if($user)
{
    $rol = $user->getRole();
}

?>

<div class="row">
        <!-- begin col-3 -->
    <div id="reception" class="col-md-3 col-sm-6" style="display: none;">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-in"></i></div>
            <div class="stats-info">
                <h4>RECEPCIONES</h4>
                <p><?php echo $receptionCount?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo Url::to(['/rd/reception/create']);?>">Realice una solocitud de recepción.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div id="wharehouse" class="col-md-3 col-sm-6" style="display: none;">
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
    <div id="dispatch" class="col-md-3 col-sm-6"  style="display: none;">
        <div class="widget widget-stats bg-purple">
            <div class="stats-icon"><i class="fa fa-building"></i></div>
            <div class="stats-info">
                <h4>DEPÓSITOS</h4>
                <p>1,291,922</p>
            </div>
            <div class="stats-link">
                <a href="javascript:;">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div id="ticket" class="col-md-3 col-sm-6"  style="display: none;">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"><i class="fa fa-ticket"></i></div>
            <div class="stats-info">
                <h4>CUPOS</h4>
                <p><?php echo $ticketCount?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo Url::to(['/rd/ticket']);?>">Ver Detalles.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div id="report" class="col-md-3 col-sm-6"  style="display: none;">
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
                                'attribute' => 'bl',
                                'label' => 'Código BL'
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
                                'header' => 'Acciones',
                                'template' => '{myButton}',  // the default buttons + your custom button
                                'controller' => 'rd/reception',
                                'buttons' => [
                                    'myButton' => function($url, $model, $key) {

                                        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
                                        $role = '';
                                        if($user)
                                            $role = $user->getRole();

                                        $result = '';
                                        $url1 = '/rd/reception/view?id='. $model->id;
                                        $url2 = '/rd/reception/trans-company?id='. $model->id;
                                        $ticketClass = $model->active == 1 ? 'btn-success' : 'btn-default';
                                        if($role === AuthItem::ROLE_AGENCY)
                                            $result = Html::a('Ver', [$url1], ['class' => 'btn btn-info btn-xs', 'data-pjax' => 0]);
                                        else if($role === AuthItem::ROLE_CIA_TRANS_COMPANY)
                                            $result = Html::a('Turnos', [$url2], ['class' => 'btn btn-xs ' . $ticketClass, 'data-pjax' => 0]);
                                        if($role === AuthItem::ROLE_ADMIN)
                                        {

                                            $result = Html::a('Ver', [$url1], ['class' => 'btn btn-info btn-xs', 'data-pjax' => 0])
                                                      .Html::a('Turnos', [$url2], ['class' => 'btn btn-xs ' . $ticketClass, 'data-pjax' => 0]);
                                        }

                                        return $result;
                                    }
                                ]
                            ],
                    ]
                    ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var role = '<?php echo $rol; ?>';
</script>

<?php
   $this->registerJsFile('@web/js/dashboard.js', ['depends' => ['app\assets\SystemAsset']]);
?>
