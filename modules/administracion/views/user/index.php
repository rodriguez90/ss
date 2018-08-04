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




<style>

    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
        padding: 5px 5px;
    }


</style>
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

                </div>
                <h4 class="panel-title">Lista de usuarios</h4>

            </div>
            <div class="panel-body">

                <?php Pjax::begin(); ?>

                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered nowrap" width="100%">
                            <thead>
                            <tr>
                            </tr>
                            </thead>
                        </table>
                    </div>

                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>

<?php $this->registerJsFile('@web/js/modules/administracion/user/index.js', ['depends' => ['app\assets\TableAsset']]); ?>





