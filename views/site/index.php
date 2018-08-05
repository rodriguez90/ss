<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\ProcessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\modules\administracion\models\AdmUser;
use app\modules\administracion\models\AuthItem;
use app\modules\rd\models\Process;
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
    <div id="import" class="col-md-3 col-sm-6" style="display: none;">
        <div class="widget widget-stats bg-green">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-in"></i></div>
            <div class="stats-info">
                <h4>Importación</h4>
                <p><?php echo $importCount?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo Url::to(['/rd/process/create','type'=>Process::PROCESS_IMPORT]);?>">Realice una solicitud de importación.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

    <!-- begin col-3 -->
    <div id="export" class="col-md-3 col-sm-6" style="display: none;">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon"><i class="fa fa-rotate-90 fa-sign-out"></i></div>
            <div class="stats-info">
                <h4>Exportación</h4>
                <p><?php echo $exportCount?></p>
            </div>
            <div class="stats-link">
                <a id="" href="<?php echo Url::to(['/rd/process/create','type'=>Process::PROCESS_EXPORT]);?>">Realice una solocitud de exportación.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
    <!-- end col-3 -->

<!--     begin col-3-->
    <div id="ticket" class="col-md-3 col-sm-6"  style="display: none;">
        <div class="widget widget-stats bg-red">
            <div class="stats-icon"><i class="fa fa-ticket"></i></div>
            <div class="stats-info">
                <h4>Turnos</h4>
                <p><?php echo $ticketCount?></p>
            </div>
            <div class="stats-link">
                <a href="<?php echo Url::to(['/rd/ticket']);?>">Ver turnos.<i class="fa fa-arrow-circle-o-right"></i></a>
            </div>
        </div>
    </div>
<!--     end col-3-->

    <!-- begin col-3 -->
    <div id="report" class="col-md-3 col-sm-6"  style="display: none;">
        <div class="widget widget-stats bg-orange">
            <div class="stats-icon"><i class="fa fa-file-pdf-o"></i></div>
            <div class="stats-info">
                <h4>REPORTES</h4>
                <p>Solicitudes</p>
            </div>
            <div class="stats-link">
                <a href="<?php echo Url::to(['/site/report']);?>">Ver Detalles <i class="fa fa-arrow-circle-o-right"></i></a>
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
                    <a id="print-process"  target="_blank" rel="noopener noreferrer" href="#" style="color: white;font-size: 14px;" title="Exportar PDF" > <i class="fa fa-file-pdf-o"></i></a>
                </div>
                <h4 class="panel-title">Solicitudes realizadas</h4>
            </div>

            <div id="panel-body" class="panel-body">

                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered nowrap" width="100%">
                        <thead>
                        <tr>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var role = '<?php echo $rol; ?>';
</script>

<?php
   $this->registerJsFile('@web/js/dashboard.js', ['depends' => ['app\assets\TableAsset']]);
?>
