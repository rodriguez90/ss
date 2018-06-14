<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Container */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;

FormAsset::register($this);

?>

<div class="container-form">

    <?php $form = ActiveForm::begin([
        'id' => 'container-form',
        'class' => 'form-horizontal',
        'enableClientScript' => false,
        'options' =>
            [
                'data-parsley-validate' => true
            ],
    ]); ?>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Nombre</label>
        <div class="col-md-9">
            <?= $form->field($model, 'name')->textInput(['class' => 'form-control','data-parsley-required'=>"true" ])->label(false)  ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Código</label>
        <div class="col-md-9">
            <?= $form->field($model, 'code')->textInput(['class' => 'form-control','data-parsley-required'=>"true" ,'data-parsley-minlength'=>"3", 'data-parsley-maxlength'=>"3" ])->label(false)  ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Toneladas</label>
        <div class="col-md-9">
            <?= $form->field($model, 'tonnage')->textInput(['class' => 'form-control','data-parsley-required'=>"true" , 'data-parsley-type'=>"number"])->label(false)  ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Activo</label>
        <div class="col-md-9">
            <?= $form->field($model, 'active')->checkbox(['data-render' => "switchery"], false)->label(false) ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label"></label>
        <div class="col-md-9">
            <?= Html::button('Cancelar', ['class' => 'btn btn-default', 'onclick' => 'window.history.go(-1)']) ?>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
    </div>


<?php ActiveForm::end(); ?>

</div>
