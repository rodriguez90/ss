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

            <div class="form-group">


                <select id="trans_company" name="trans_company" class="form-control selectpicker" data-size="10"
                        data-live-search="true">
                    <?php

                    echo "<option  value=''>Seleccione BL o Booking</option>";

                    foreach ($process as $p) {
                        echo "<option value='" . $p->bl . "'>" . $p->bl . "</option>";
                    }

                    ?>
                </select>

            </div>




            <div class="form-group">


                    <select id="selectpicker-agency" name="agency_id" class="form-control selectpicker" data-size="10"
                            data-live-search="true">
                        <?php

                        echo "<option  value=''>Seleccione Agencia</option>";

                        foreach ($agency as $a) {
                            echo "<option value='" . $a->id . "'>" . $a->name . "</option>";
                        }

                        ?>
                    </select>

            </div>




        </div>

        <div class="col col-md-6">

            <div class="form-group">


                <select id="selectpicker-bl" name="bl" class="form-control selectpicker" data-size="10"
                        data-live-search="true">
                    <?php

                    echo "<option  value=''>Seleccione Compañía de Trabsporte</option>";

                    foreach ($trans_company as $t) {
                        echo "<option value='" . $t->id . "'>" . $t->name . "</option>";
                    }

                    ?>
                </select>

            </div>


        </div>
    </div>

    <?php // echo $form->field($model, 'type') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Limpiar'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
