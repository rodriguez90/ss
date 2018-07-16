<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Registrarse';
$this->params['breadcrumbs'][] = $this->title;
?>



<style>
    .login{
        width: 75% !important;
    }
</style>




<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

<div class="login-cover">
    <div class="login-cover-image"><img width="100%px" height="100%px" src=<?php echo \yii\helpers\Url::to("@web/img/login-bg/tpg-2.jpeg");?> data-id="login-cover-image" alt="" /></div>
    <div class="login-cover-bg"></div>
</div>

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login login-v2" data-pageload-addclass="animated fadeIn">
        <!-- begin brand -->
        <div class="login-header" style="text-align: center">
            <div class="brand">
                <span class="logo"></span> SGT
                <small>Sistema de Gestion de Turnos </small>
            </div>
        </div>
        <!-- end brand -->


            <?php $form = ActiveForm::begin([
                'id' => 'user-form',
                'enableClientScript' => false,
                'options' =>
                    [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal',
                        'data-parsley-validate' => true
                    ],
            ]); ?>

            <!-- end register-header -->
            <!-- begin register-content -->
            <div class="register-content row" style="margin: 20px;">
                <div class="col-sm-12" style="text-align: center;">

                    <h1 class="register-header">
                        <small>Registrarse</small>
                    </h1>
                    <?php if ($model->hasErrors()) {
                        ?>
                        <section>
                            <?php foreach ($model->errors as $key => $value) {
                                ?>

                                <div class="alert alert-danger fade in m-b-15">
                                    <i class="fa fa-warning"></i>
                                    <strong>Error! </strong> <?= $value[0]; ?>
                                    <span class="close" data-dismiss="alert">×</span>
                                </div>

                            <?php } ?>
                        </section>
                    <?php }   ?>



                </div>


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

                <div class="col-md-6" >

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4">Contrase&ntilde;a*</label>

                        <div class="col-md-8 col-sm-8">
                            <input name="AdmUser[password]" data-parsley-required="true"  type="password"  Class="form-control"/>

                            <!--div id="passwordStrengthDiv" class="is0 m-t-5"></div-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4"> Confirmar*</label>

                        <div class="col-md-8 col-sm-8">
                            <input name="AdmUser[passwordConfirm]" data-parsley-required="true"  type="password"
                                   class="form-control"/>

                        </div>
                    </div>

                    <div class="form-group">

                        <label class="control-label col-md-4 col-sm-4">Tipo*</label>
                        <div class="col-md-8 col-sm-8">
                            <select id="selectpicker-type" name="usertype"  class='form-control'  data-parsley-required='true'>
                                <option value=''>Tipo de Usuario</option>
                                <option value="1">Importador</option>
                                <option value="2">Exportador</option>
                                <option value="3">Importador/Exportador</option>
                                <option value="4">Empresa de Transporte</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="div-type">
                        <label class="control-label col-md-4 col-sm-4" id="label-type">---</label>

                        <div class="col-md-8 col-sm-8" id="select-conten"  >

                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom: 15px;">
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <div class="register-buttons">
                            <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
    </div>
    <!-- end login -->
</div>





<?php $this->registerJsFile('@web/js/register.js', ['depends' => ['app\assets\FormAsset']]); ?>
