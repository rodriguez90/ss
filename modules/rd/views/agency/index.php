<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\rd\models\AgencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Agencias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agency-index">

    <div class="panel panel-inverse" data-sortable-id="index-1">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
            <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a(Yii::t('app', 'Nueva Agencia'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>

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

<?php $this->registerJsFile('@web/js/modules/rd/agency/index.js', ['depends' => ['app\assets\TableAsset']]); ?>