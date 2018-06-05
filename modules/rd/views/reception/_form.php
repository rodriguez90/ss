<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reception-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bl')->textInput() ?>

    <?= $form->field($model, 'trans_company_id')->textInput() ?>

    <?= $form->field($model, 'agency_id')->textInput() ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
