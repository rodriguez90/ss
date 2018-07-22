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
use yii\bootstrap\ActiveForm;

$this->title = 'Report';

$user = Yii::$app->user->identity;
$rol = '';
$asociatedEntity = [];

if ($user)
{
    $rol = $user->getRole();
    $result = $user->asociatedEntity();
    if($result !== null && $result !== true)
    {
        $asociatedEntity['id'] = $result->id;
        $asociatedEntity['name'] = $result->name;
    }
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

                    <?php /*echo $this->render('_search', ['model' => $searchModel,
                        'search_bl' => $search_bl,
                        'search_agency_id' => $search_agency_id,
                        'search_trans_company' => $search_trans_company,
                        'dataProvider' => $dataProvider,

                    ]);*/
                    ?>

                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'report-form',
                        'enableClientScript' => false,
                        'options' =>
                            [
                                'enctype' => 'multipart/form-data',
                                'class' => 'form-horizontal',

                            ],
                    ]
                ); ?>

                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <select id="bl" name="bl" class="form-control"></select>
                            </div>
                        </div>

                    </div>

                    <div id="agency_container"  class="col-md-4 col-sm-4" style="display: none;">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <select id="agency_id" name="agency_id" class="form-control">

                                    <?php
                                        if($rol == 'Importador_Exportador')
                                        {
                                            echo "<option selected value='" . $asociatedEntity['id'] . "'>" . $asociatedEntity['name'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div id='trans_company_container' class="col-md-4 col-sm-4" style="display: none;">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <select  id="trans_company_id" name="trans_company_id" class="form-control">
                                    <?php
                                    if($rol == 'Cia_transporte')
                                    {
                                        echo "<option selected value='" . $asociatedEntity['id'] . "'>" . $asociatedEntity['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12">

                        <div class="col-md-4 col-sm-4">

                        </div>
                        <div class="col-md-4 col-sm-4">

                        </div>
                        <div class="col-md-4 col-sm-4">

                            <div class="form-group" style="float: right">

                                <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>

                                <a id="print-process" class="<?= $dataProvider !=null ?  'btn btn-inverse' : 'btn btn-inverse disabled' ?>"  href="<?= Url::to(['/site/printreport?bl='.$search_bl."&agency_id=".$search_agency_id."&trans_company_id=".$search_trans_company]) ?>" style="color: white;font-size: 14px;" title="Exportar PDF" > <i class="fa fa-file-pdf-o"></i></a>

                            </div>

                        </div>

                    </div>

                <?php ActiveForm::end(); ?>

                    <div class="col-md-12 col-sm-12">
                        <?php
                        if ($dataProvider != null)
                        {
                           echo GridView::widget([
                                'dataProvider' => $dataProvider,
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
    //                                    'attribute' => 'containerAmount'
                                        'value'=>function($model)
                                        {
                                            return count($model->getProcessTransactionsByUser());
                                        }
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
                        }
                        ?>
                    </div>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var role = '<?php echo $rol; ?>';
    var data = <?php echo json_encode($asociatedEntity);?>;
</script>

<?php $this->registerJsFile('@web/js/report.js', ['depends' => ['app\assets\FormAsset']]); ?>


