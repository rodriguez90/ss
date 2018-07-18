<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>








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
        <div class="login-content">

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
            ]); ?>


                <div class="form-group m-b-20">
                    <input type="text" class="form-control input-lg" placeholder="Nombre de Usuario" name="LoginForm[username]" />
                </div>
                <div class="form-group m-b-20">
                    <input type="password" class="form-control input-lg" placeholder="Contraseña" name="LoginForm[password]" />
                </div>
                <div class="checkbox m-b-20">
                    <label>
                        <input type="checkbox" /> Recordarme
                    </label>
                </div>


                <div class="login-buttons">
                    <button type="submit" class="btn btn-success btn-block btn-lg">Entrar</button>
                </div>

            <div class="m-t-20">
<!--              Regístrate <a href=" --><?//= Url::to(['/site/register']) ?><!--" class="text-success">aquí</a>-->
              Regístrate <a href="http://www.tpg.com.ec/webtpg/webpages/wpg_preregistro.php" class="text-success">aquí</a>
            </div>


            <ul class="parsley-errors-list filled" style="text-align: center;" >
                <li class="parsley-required"> <?php if(isset($msg)){ echo $msg; } ?></li>
            </ul>




            <?php ActiveForm::end(); ?>


        </div>
    </div>
    <!-- end login -->
</div>