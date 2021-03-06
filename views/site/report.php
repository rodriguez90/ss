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
        $asociatedEntity['name'] = utf8_encode($result->name);
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
                <div class="col col-md-12">
                    <div class="row">
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
                                        if($rol == 'Importador_Exportador' || $rol == 'Importador_Exportador_Especial')
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
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-md-4 col-sm-4">
                            </div>
                            <div class="col-md-4 col-sm-4">
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group" style="float: right">
                                    <a id="search" class="btn btn-primary"  href="#">Buscar</a>
                                    <a id="print-process" target="_blank" rel="noopener noreferrer" class="btn btn-inverse"  href="#" style="color: white;font-size: 14px;" title="Exportar PDF" > <i class="fa fa-file-pdf-o"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
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
        </div>
    </div>
</div>


<script type="text/javascript">
    var role = '<?php echo $rol; ?>';
    var asociatedEntity = <?php echo json_encode($asociatedEntity);?>;
</script>

<?php $this->registerJsFile('@web/js/report.js', ['depends' => ['app\assets\FormAsset','app\assets\TableAsset' ]]); ?>
<?php $this->registerJsFile('@web/js/utils.js'); ?>


