<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles */




?>



<div class="user-form">



    <?php if ($model->hasErrors())
    { ?>
        <section>
            <?php foreach ($model->errors as $key => $value)
            {
                ?>

                <div class="alert alert-danger fade in m-b-15">

                    <i class="fa fa-warning"></i>
                    <strong>Error!</strong> <?= $value[0]; ?>
                    <span class="close" data-dismiss="alert">×</span>
                </div>


            <?php } ?>
        </section>
    <?php } ?>


    <div class="row">

        <div class="col-md-10 ui-sortable">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-validation-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Crear Usuario</h4>
                </div>
                <div class="panel-body panel-form">

                    <?php $form = ActiveForm::begin(
                        [
                            'id' => 'descargas-form',
                            'enableClientScript' => false,
                            'options' =>
                            [
                                'enctype' => 'multipart/form-data',
                                'class' => 'form-horizontal form-bordered',
                                'data-parsley-validate'=>true
                            ],
                        ]
                    ); ?>



                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="website">Nombre* :</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[nombre]"   placeholder="Nombre" data-parsley-required="true" type="text" value="<?= $model['nombre'] ?>">
                                <ul  class="parsley-errors-list"></ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="website">Apellidos* :</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[apellidos]"   placeholder="Apellidos" data-parsley-required="true" type="text" value="<?= $model['apellidos'] ?>">
                                <ul  class="parsley-errors-list"></ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">Nombre de usuario* :</label>
                            <div class="col-md-8 col-sm-8">
                                <input  class="form-control"  name="AdmUser[username]" placeholder="nombreusuario85" data-parsley-required="true" type="text"  value="<?= $model['username'] ?>">
                                 <ul   class="parsley-errors-list"></ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="email">Email* :</label>
                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[email]" data-parsley-type="email" placeholder="Email" data-parsley-required="true" type="text" value="<?= $model['email'] ?>">
                                <ul  class="parsley-errors-list"></ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4">Contrase&ntilde;a*</label>
                            <div class="col-md-8 col-sm-8">
                                <input name="AdmUser[password]" id="password-indicator-default"  type="password"   class="form-control m-b-5" />
                                <div id="passwordStrengthDiv" class="is0 m-t-5"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4"> Confirmar contrase&ntilde;a </label>
                            <div class="col-md-8 col-sm-8">
                                <input name="AdmUser[passwordConfirm]" id="password-passwordConfirm"  type="password"  class="form-control" />

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4">Activo</label>
                            <div class="col-md-8 col-sm-8">
                                <input  type="checkbox" <?= isset($model['status']) || $model->isNewRecord ? 'checked' : '' ?>
                                    name="AdmUser[status]"
                                    value="1"/>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-md-4">Rol</label>
                            <div class="col-md-8">
                                <input type="text" name="rol" id="jquery-autocomplete" data-parsley-required="true" class="form-control" value="<?= $rol_actual?>"/>
                            </div>
                        </div>


                        <div class="form-group" id="div-type" >
                            <label class="control-label col-md-4" id="label-type">---</label>
                            <div class="col-md-8">
                                <input type="text" name="" id="input-type"  class="form-control" />
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
            <!-- end panel -->
        </div>
    </div>


</div>


<?php




$this->registerJsFile('@web/js/modules/administracion/user.js', ['depends' => ['app\assets\AppAsset']]);
?>



