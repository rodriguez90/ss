<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 16/06/2018
 * Time: 06:39 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use app\assets\FormAsset;
FormAsset::register($this);
?>

<div class="user-form">

    <?php if ($result["status"] != -1) {
        ?>
        <section>

            <?php if ($result["status"] == 0) {
                ?>
                <div class="alert alert-danger fade in m-b-15">
                    <i class="fa fa-warning"></i>
                    <strong>Error!</strong> <?= $result["msg"] ?>
                    <span class="close" data-dismiss="alert">×</span>
                </div>

            <?php } ?>

            <?php if ($result["status"] == 1) {
                ?>
                <div class="alert alert-success fade in m-b-15">
                    <?= $result["msg"] ?>
                    <span class="close" data-dismiss="alert">×</span>
                </div>
            <?php } ?>
        </section>
    <?php } ?>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"> Generar Carta de Servicio</h4>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(
                        [
                            'id' => 'generator-form',
                            'enableClientScript' => false,
                            'options' =>
                                [
                                    'enctype' => 'multipart/form-data',
                                    'class' => 'form-horizontal',
                                    'data-parsley-validate' => true
                                ],
                        ]
                    ); ?>

                    <div class="form-group">
                        <label class="col-md-4 col-sm-4 control-label">BL o Booking</label>
                        <div class="col-md-8 col-sm-8">

                            <select id="selectpicker-bl" name="bl"  data-parsley-required="true" class="form-control" data-size="10" data-live-search="true">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-sm-4">
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <?= Html::button('Cancelar',['class'=>'btn btn-default','onclick'=>'window.history.go(-1)']) ?>
                            <a id="generateSrvCard"  class="btn btn-success m-r-5" target="_blank" rel="noopener noreferrer" href="#" style="color: white;font-size: 14px;" title="Generar PDF" > <i class="fa fa-file-pdf-o"></i> Generar</a>
                        </div>
                        <div class="col-md-4 col-sm-4">
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJsFile('@web/js/modules/rd/process/generatingcard.js', ['depends' => ['app\assets\FormAsset']]);?>





