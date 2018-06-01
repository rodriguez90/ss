<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-validation-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Crear roles y permisos</h4>
            </div>
            <div class="panel-body panel-form">

                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'item-form',
                        'enableClientScript' => false,
                        'options' =>
                            [
                                'class' => 'form-horizontal form-bordered',
                                'data-parsley-validate'=>true
                            ],
                    ]
                ); ?>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4" for="fullname">Nombre * :</label>
                        <div class="col-md-8 col-sm-8">
                            <input id="authitem-name" class="form-control" name="AuthItem[name]"  data-parsley-required="true" type="text" value="<?= $model->name ?>">
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="control-label col-md-4 col-sm-4" for="email">Tipo * :</label>
                        <div class="col-md-8 col-sm-8">
                            <?= Html::activeDropDownList($model, 'type',[1=>'Rol',2=>'Permiso'], ['class' => 'form-control' , 'data-parsley-required'=>true]); ?>
                        </div>
                    </div-->

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="email">Descripción :</label>
                    <div class="col-md-8 col-sm-8">
                        <textarea id="authitem-description" class="form-control" name="AuthItem[description]" rows="2" ><?= $model->description?></textarea>
                    </div>
                </div>


                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4"></label>
                        <div class="col-md-8 col-sm-8">
                            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>
