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
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\ProcessSearch */
/* @var $form yii\widgets\ActiveForm */
?>



<?php $form = ActiveForm::begin(
    [
        'id' => 'report-form',
        'enableClientScript' => false,
        'options' =>
            [
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal',

            ],
    ]
); ?>


<div class="col-md-4 col-sm-4">

    <div class="form-group">
        <div class="col-md-12 col-sm-12">
            <select id="bl" name="bl" class="form-control selectpicker" data-size="10"
                    data-live-search="true">
                <?php

                echo "<option  value=''>Seleccione BL o Booking</option>";


                foreach ($process as $p) {
                    $selected = $p->bl == $search_bl ? "selected=''": '';
                    echo "<option ".$selected. " value='" . $p->bl . "'>" . $p->bl . "</option>";
                }

                ?>
            </select>
        </div>
    </div>

</div>


<div class="col-md-4 col-sm-4">
    <div class="form-group">
        <div class="col-md-12 col-sm-12">
            <select id="selectpicker-agency" name="agency_id" class="form-control selectpicker" data-size="10"
                    data-live-search="true">
                <?php

                echo "<option  value=''>Seleccione Agencia</option>";

                foreach ($agency as $a) {
                    $selected = $a->id == $search_agency_id ? "selected=''": '';
                    echo "<option ".$selected. " value='" . $a->id . "'>" . $a->name . "</option>";
                }

                ?>
            </select>
        </div>

    </div>
</div>

<div class="col-md-4 col-sm-4">

    <div class="form-group">

        <div class="col-md-12 col-sm-12">
            <select id="selectpicker-bl" name="trans_company" class="form-control selectpicker" data-size="10"
                    data-live-search="true">
                <?php

                echo "<option  value=''>Seleccione Compañía de Trabsporte</option>";

                foreach ($trans_company as $t) {
                    $selected = $t->id == $search_trans_company ? "selected=''": '';
                    echo "<option ".$selected. " value='" . $t->id . "'>" . $t->name . "</option>";
                }

                ?>
            </select>
        </div>

    </div>
</div>


<div class="col-md-12 col-sm-12">

    <div class="col-md-4 col-sm-4">

    </div>
    <div class="col-md-4 col-sm-4">


    </div>
    <div class="col-md-4 col-sm-4">

        <div class="form-group" style="float: right">

            <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>

            <a id="print-process" class="<?= $dataProvider !=null ?  'btn btn-inverse' : 'btn btn-inverse disabled' ?>"  href="<?= Url::to(['/site/printreport?bl='.$search_bl."&agency_id=".$search_agency_id."&trans_company_id=".$search_trans_company]) ?>" style="color: white;font-size: 14px;" title="Exportar PDF" > <i class="fa fa-file-pdf-o"></i></a>

        </div>

    </div>

</div>

<?php ActiveForm::end(); ?>


