<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $roles */

use app\assets\FormAsset;
FormAsset::register($this);

?>

<div class="user-form">


    <?php if ($model->hasErrors()) {
        ?>
        <section>
            <?php foreach ($model->errors as $key => $value) {
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
        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    </div>
                    <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
                </div>
                <div class="panel-body">

                    <?php $form = ActiveForm::begin(
                        [
                            'id' => 'user-form',
                            'enableClientScript' => false,
                            'options' =>
                                [
                                    'enctype' => 'multipart/form-data',
                                    'class' => 'form-horizontal',
                                    'data-parsley-validate' => true
                                ],
                        ]
                    ); ?>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="website">Nombre*</label>

                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[nombre]" placeholder="Nombre"
                                       data-parsley-required="true" type="text" value="<?= $model['nombre'] ?>">
                                <ul class="parsley-errors-list"></ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="website">Apellidos*</label>

                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[apellidos]" placeholder="Apellidos"
                                       data-parsley-required="true" type="text" value="<?= $model['apellidos'] ?>">
                                <ul class="parsley-errors-list"></ul>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="fullname">Nombre de usuario*</label>

                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[username]" placeholder="nombreusuario85"
                                       data-parsley-required="true" type="text" value="<?= $model['username'] ?>">
                                <ul class="parsley-errors-list"></ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4" for="email">Email*</label>

                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[email]" data-parsley-type="email"
                                       placeholder="Email" data-parsley-required="true" type="text"
                                       value="<?= $model['email'] ?>">
                                <ul class="parsley-errors-list"></ul>
                            </div>
                        </div>

                        <div class="form-group">

                            <label class="control-label col-md-4 col-sm-4" for="fullname">Cedula*</label>

                            <div class="col-md-8 col-sm-8">
                                <input class="form-control" name="AdmUser[cedula]" placeholder=""
                                      data-parsley-required="true"  data-parsley-type="number" data-parsley-maxlength="10" data-parsley-minlength="10"  type="text" value="<?= $model['cedula'] ?>">
                                <ul class="parsley-errors-list"></ul>
                            </div>
                        </div>


                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4">Contrase&ntilde;a*</label>

                            <div class="col-md-8 col-sm-8">
                                <input name="AdmUser[password]"   type="password"  Class="form-control"/>

                                <!--div id="passwordStrengthDiv" class="is0 m-t-5"></div-->
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4"> Confirmar contrase&ntilde;a</label>

                            <div class="col-md-8 col-sm-8">
                                <input name="AdmUser[passwordConfirm]"   type="password"
                                       class="form-control"/>

                            </div>
                        </div>



                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4">Rol</label>


                        <div class="col-md-8 col-sm-8"  <?= \Yii::$app->user->can('admin_mod') ? "": "style='visibility: hidden'"?> >
                            <select id="selectpicker-rol" name="rol"  data-parsley-required="true" class="form-control selectpicker" data-size="10" data-live-search="true"  >
                                <?php

                                echo "<option  value=''>Seleccione un Rol</option>";

                                foreach($roles as $r){
                                    $selected = $rol_actual == $r->name ? 'selected': '';
                                    echo "<option ".$selected." value='".$r->name ."'>". $r->name ."</option>";
                                }

                                ?>
                            </select>

                        </div>
                        </div>


                        <div class="form-group" id="div-type">
                            <label class="control-label col-md-4 col-sm-4" id="label-type">---</label>

                            <div class="col-md-8 col-sm-8" id="select-conten"  <?= \Yii::$app->user->can('admin_mod') ? "": "style='visibility: hidden'"?>>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4">Activo</label>
                            <div class="col-md-8 col-sm-8"  <?= \Yii::$app->user->can('admin_mod') ? "": "style='visibility: hidden'"?>>

                                <input data-switchery="true" id="admuser-status" name="status" value="1" data-render="switchery" type="checkbox" <?= $model->isNewRecord || $model->status  ? 'checked=""' : '' ?> >

                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 col-sm-12" style="margin-bottom: 25px;">

                    <div class="col-md-4 col-sm-3">
                        <input style="visibility: hidden" name="aux" value="<?= $type ?>" id="aux" />

                    </div>


                    <div class="col-md-4 col-sm-6">

                                <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>

                                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <div class="col-md-4 col-sm-3">
                    </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>


</div>

<?php
$this->registerJsFile('@web/js/modules/utiles.js',              ['depends' => ['app\assets\FormAsset']]);
$this->registerJsFile('@web/js/modules/administracion/user.js', ['depends' => ['app\assets\FormAsset']]);
?>





