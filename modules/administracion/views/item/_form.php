<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

use app\assets\FormAsset;
FormAsset::register($this);


?>


<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="form-validation-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>

                </div>
                <h4 class="panel-title"> <?= $type == 1 ? 'Crear Rol':'Crear Permiso' ?></h4>
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


                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="email">Descripción :</label>
                    <div class="col-md-8 col-sm-8">
                        <textarea id="authitem-description" class="form-control" name="AuthItem[description]" rows="2" ><?= $model->description?></textarea>
                    </div>
                </div>





                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4"></label>
                        <div class="col-md-8 col-sm-8">
                            <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>
                            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
</div>
