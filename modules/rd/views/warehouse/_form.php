<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;
FormAsset::register($this);
?>

<!--<div class="warehouse-form">-->

    <?php $form = ActiveForm::begin(['class'=>'form-horizontal']); ?>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Nombre</label>
        <div class="col-md-9">
            <?= $form->field($model, 'name')->textInput(['class'=>'form-control'])->label(false) ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Código OCE</label>
        <div class="col-md-9">
            <?= $form->field($model, 'code_oce')->textInput(['class'=>'form-control'])->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Ruc</label>
        <div class="col-md-9">
            <?= $form->field($model, 'ruc')->textInput(['class'=>'form-control'])->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Activo</label>
        <div class="col-md-9">
            <?= $form->field($model, 'active')->checkbox(['data-render'=>"switchery"], false)->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label"></label>
        <div class="col-md-9">
            <?= Html::submitButton(Yii::t('app', 'Salvar'), ['class' => 'btn btn-sm btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
<!--</div>-->
