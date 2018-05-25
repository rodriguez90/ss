<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_oce')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput(['type'=>'checkbox',
                                                           'data-render'=>'switchery',
                                                           'data-theme'=>'default']) ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
//    $this->registerJsFile('@web/js/form-slider-switcher.demo.min.js', ['depends' => ['app\assets\SystemAsset']]);
//?>

