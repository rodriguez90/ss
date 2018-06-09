<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItemChild */
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
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title"> Asignar permiso a un rol </h4>
            </div>
            <div class="panel-body panel-form">

                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'descargas-form',
                        'enableClientScript' => false,
                        'options' =>
                            [
                                'class' => 'form-horizontal form-bordered',
                                'data-parsley-validate'=>true
                            ],
                    ]
                ); ?>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="fullname">Rol * :</label>
                    <div class="col-md-8 col-sm-8">
                        <input id="authitemchild-parent" class="form-control" name="AuthItemChild[parent]"  data-parsley-required="true" type="text" value="<?= $model->parent ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-4 col-sm-4" for="fullname">Permiso * :</label>
                    <div class="col-md-8 col-sm-8">

                        <select id="selectpicker-item" name="AuthItemChild[child]"  data-parsley-required="true" class="form-control selectpicker" data-size="10" data-live-search="true" >
                            <?php

                            echo "<option  value=''>Seleccione un Permiso</option>";

                            foreach($items as $item){

                                echo "<option  value='".$item->name ."'>". $item->name ."</option>";
                            }

                            ?>
                        </select>


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




<?php
$this->registerJsFile('@web/js/modules/administracion/permisos.js', ['depends' => ['app\assets\FormAsset']]);
?>
