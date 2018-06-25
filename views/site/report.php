<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 27/06/2018
 * Time: 2:18
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\modules\administracion\models\AdmUser;
use app\modules\administracion\models\AuthItem;
use app\modules\rd\models\Process;

$this->title = 'Report';

$user = AdmUser::findOne(['id' => Yii::$app->user->getId()]);
$rol = '';
if ($user) {
    $rol = $user->getRole();
}

$this->title = 'Reporte';
//$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- begin row -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                                class="fa fa-expand"></i></a>

                </div>
                <h4 class="panel-title">Solicitudes realizadas</h4>
            </div>

            <div class="panel-body">

                <?php Pjax::begin(); ?>
                <?php echo $this->render('_search', ['model' => $searchModel,
                    'trans_company' => $trans_company,
                    'agency' => $agency,
                    'process' => $process,
                    'search_bl' => $search_bl,
                    'search_agency_id' => $search_agency_id,
                    'search_trans_company' => $search_trans_company,
                    'dataProvider' => $dataProvider,

                ]);
                ?>


                <div class="col-md-12 col-sm-12">
                    <?php
                    if ($dataProvider !=null) { ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
//                    'filterModel' => $searchModel,
                            'columns' => [

                                [
                                    'class' => 'yii\grid\DataColumn',
                                    'attribute' => 'bl',
                                    'label' => 'BL'
                                ],
                                [
                                    'class' => 'yii\grid\DataColumn',
                                    'attribute' => 'id',
                                    'label' => 'Número de recepción'
                                ],
                                [
                                    'class' => 'yii\grid\DataColumn',
                                    'attribute' => 'agency_id',
                                    'value' => 'agency.name',
                                ],
                                [
                                    'attribute' => 'delivery_date',
                                    'format' => 'date',
                                ],
                                [
                                    'class' => 'yii\grid\DataColumn',
                                    'label' => "Contenedores",
                                    'attribute' => 'containerAmount'
                                ],
                                [
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'attribute' => 'type',
                                    'value' => function ($data) {
                                        return Process::PROCESS_LABEL[$data['type']];
                                    },
                                    'filter' => ['1' => 'Importación', '2' => 'Exportación',],
                                ],
                            ],
                            'options' => ['class' => 'table table-striped table-bordered']
                        ]);
                        ?>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->registerJsFile('@web/js/report.js', ['depends' => ['app\assets\FormAsset']]); ?>


