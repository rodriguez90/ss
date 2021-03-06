<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\TransCompany */

$this->title = 'Nueva Compañía de Transporte';
$this->params['breadcrumbs'][] = ['label' => 'Compañías de Transporte', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-10 col-sm-10">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                                class="fa fa-expand"></i></a>
                </div>
                <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
            </div>
            <div class="panel-body">
                <?= $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>

</div>
