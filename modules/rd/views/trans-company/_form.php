<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\TransCompany */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;
FormAsset::register($this);

?>

<div class="trans-company-form">


    <?php $form = ActiveForm::begin([
        'id' => 'trans-company-form',
        'class' => 'form-horizontal',
        'enableClientScript' => false,
        'options' =>
            [
                'data-parsley-validate' => true
            ],
    ]); ?>


    <div class="col-md-6 col-sm-6" >
        <div class="form-group">
            <label class="col-md-3 col-sm-3 control-label">Nombre</label>
            <div class="ccol-md-9 col-sm-9">
                <?= $form->field($model, 'name')->textInput(['class' => 'form-control','data-parsley-required'=>"true" ])->label(false)  ?>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 col-sm-3 control-label">Dirección</label>
            <div class="col-md-9 col-sm-9">
                <?= $form->field($model, 'address')->textarea(['rows' => 3])->label(false)  ?>
            </div>
        </div>


        <div class="form-group">
            <label class="col-md-3 col-sm-3 control-label">Activa</label>
            <div class="col-md-9 col-sm-9">
                <?= $form->field($model, 'active')->checkbox(['data-render'=>"switchery", "data-theme"=>"blue"], false)->label(false)  ?>
            </div>
        </div>

    </div>
    <div class="col-md-6 col-sm-6" id="colum2">

        <div class="form-group">
            <label class="col-md-3 col-sm-3 control-label">RUC</label>
            <div class="col-md-9 col-sm-9">
                <?= $form->field($model, 'ruc')->textInput(['class' => 'form-control','data-parsley-required'=>"true" , 'data-parsley-type'=>"number",'data-parsley-minlength'=>"13", 'data-parsley-maxlength'=>"13"])->label(false) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-3 col-sm-3 control-label">Teléfono</label>
            <div class="col-md-7 col-sm-7">
                <input name="telefono-0"   type="text" value="<?= $number1->phone_number ?>"  class="form-control" data-parsley-required="true" data-parsley-type="number" data-parsley-maxlength="10" data-parsley-minlength="9" />
            </div>
            <div class="col-md-2 col-sm-2">
                <a id="add-phone" class="btn btn-primary"  title="Adicionar Teléfono" > <i class="fa fa-plus"></i></a>
            </div>
        </div>

        <?php
            $nphone = 1;
            foreach ( $phones as $p){
               echo "<div id='group-" . $nphone . "' class='form-group phone' >";
               echo "<label class='col-md-3 col-sm-3 control-label'>Teléfono</label>";
               echo "<div class='col-md-7 col-sm-7'>";
               echo "<input name='telefono-".$nphone."' type='text' value='".$p->phone_number."'  class='form-control' data-parsley-required='true' data-parsley-type='number' data-parsley-maxlength='12' data-parsley-minlength='12'/>";
               echo " </div> ";
               echo "<div class='col-md-2 col-sm-2'>";
               echo " <a id='btn-".$nphone."' class='btn btn-danger'  title='Eliminar Teléfono' > ";
               echo "<i class='fa fa-minus'></i></a> ";
               echo "</div> </div>";
                $nphone++;
            }
        ?>


    </div>

    <div class="col-md-12 col-sm-12">
        <div class="col-md-3 col-sm-3">
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-md-3 col-sm-3 control-label"></label>
                <div class="col-md-9">
                    <?= Html::button('Cancelar', ['class' => 'btn btn-default', 'onclick' => 'window.history.go(-1)']) ?>
                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3">
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php $this->registerJsFile('@web/js/modules/rd/transcompany/addphone.js',['depends' => ['app\assets\FormAsset']]);?>

