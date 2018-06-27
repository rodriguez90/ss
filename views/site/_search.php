<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 27/06/2018
 * Time: 2:23
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\ProcessSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="process-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1,
        ],
    ]); ?>

    <div class="row">
        <div class="col col-md-6">

            <?= $form->field($model, 'bl')->label('BL o Booking') ?>

            <?= $form->field($model, 'agency_id') ?>

        </div>

        <div class="col col-md-6">

            <?= $form->field($model, 'trans_company') ?>

        </div>
    </div>

    <?php // echo $form->field($model, 'type') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Limpiar'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
