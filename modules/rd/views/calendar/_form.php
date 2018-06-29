<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\CalendarAsset;
CalendarAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Calendar */
/* @var $form yii\widgets\ActiveForm */


?>

<style>
    .fc-axis {
        height: 30px !important;

    }

    .fc-content{
        text-align: center !important;
    }


    .input-daterange {
        width: 100% !important;
    }


</style>
<!--div class="calendar-form">

</div-->


<div class="row">


    <!-- begin panel -->
    <div class="panel panel-inverse" data-sortable-id="form-validation-1">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                   data-click="panel-expand"><i class="fa fa-expand"></i></a>


            </div>
            <h4 class="panel-title"> <?= $this->title ?> </h4>
        </div>


        <div class="panel-body panel-form" style="margin-top: 15px;">

            <?php $form = ActiveForm::begin(
                [
                    'id' => 'calendat-form',
                    'enableClientScript' => false,
                    'options' =>
                        [
                            'class' => 'form-horizontal',
                            'data-parsley-validate' => true
                        ],
                ]
            ); ?>


            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label class="col-md-2 col-sm-2 control-label">Rango</label>
                    <div class="col-md-10 col-sm-10">
                        <div class="input-group input-daterange" id="range">
                            <input type="text" class="form-control" id="start" placeholder="Desde"/>
                            <span class="input-group-addon">Hasta</span>
                            <input type="text" class="form-control" id="end" placeholder="Hasta"/>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 25px;">
                    <label class="control-label col-md-2 col-sm-2" for="amount">Cupos:</label>
                    <div class="col-md-10 col-sm-10">
                        <input class="form-control" type="text" id="amount" name="Calendar[amount]"
                               data-parsley-type="number" placeholder="Cantidad por hora" />
                    </div>
                </div>


            </div>


            <div class="col-md-6 col-sm-12" style="text-align: center;">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="col-md-2 col-sm-4 control-label">Horas</label>
                        <div class="col-md-10 col-sm-12">
                            <select id="selectpicker-desde" name="start" data-parsley-required="true"
                                    class="form-control selectpicker" data-size="10" data-live-search="true">
                                <option value=''>Seleccione Desde</option>
                                <option value='0'>00:00</option>
                                <option value='1'>1:00</option>
                                <option value='2'>2:00</option>
                                <option value='3'>3:00</option>
                                <option value='4'>4:00</option>
                                <option value='5'>5:00</option>
                                <option value='6'>6:00</option>
                                <option value='7'>7:00</option>
                                <option value='8'>8:00</option>
                                <option value='9'>9:00</option>
                                <option value='10'>10:00</option>
                                <option value='11'>11:00</option>
                                <option value='12'>12:00</option>
                                <option value='13'>13:00</option>
                                <option value='14'>14:00</option>
                                <option value='15'>15:00</option>
                                <option value='16'>16:00</option>
                                <option value='17'>17:00</option>
                                <option value='18'>18:00</option>
                                <option value='19'>19:00</option>
                                <option value='20'>20:00</option>
                                <option value='21'>21:00</option>
                                <option value='22'>22:00</option>
                                <option value='23'>23:00</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="col-md-2 col-sm-12 control-label"></label>
                        <div class="col-md-10 col-sm-12">
                            <select id="selectpicker-hasta" name="end" data-parsley-required="true"
                                    class="form-control selectpicker" data-size="10" data-live-search="true">
                                <option value=''>Seleccione Hasta</option>
                                <option value='0'>00:00</option>
                                <option value='1'>1:00</option>
                                <option value='2'>2:00</option>
                                <option value='3'>3:00</option>
                                <option value='4'>4:00</option>
                                <option value='5'>5:00</option>
                                <option value='6'>6:00</option>
                                <option value='7'>7:00</option>
                                <option value='8'>8:00</option>
                                <option value='9'>9:00</option>
                                <option value='10'>10:00</option>
                                <option value='11'>11:00</option>
                                <option value='12'>12:00</option>
                                <option value='13'>13:00</option>
                                <option value='14'>14:00</option>
                                <option value='15'>15:00</option>
                                <option value='16'>16:00</option>
                                <option value='17'>17:00</option>
                                <option value='18'>18:00</option>
                                <option value='19'>19:00</option>
                                <option value='20'>20:00</option>
                                <option value='21'>21:00</option>
                                <option value='22'>22:00</option>
                                <option value='23'>23:00</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 col-sm-12">
                    <div class="col-md-8 col-sm-8">
                        <div class="col-md-12 col-sm-12 m-t-10">
                        <label class="label label-success p-10 f-s-12">Nuevo</label>

                        <label class="label label-primary p-10 f-s-12">Existente</label>

                        <label class="label bg-purple p-10 f-s-12">Actualizado</label>
                        </div>



                    </div>
                    <div class="col-md-4 col-sm-4" style="text-align: right;padding-right:0px;">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12">
                                <button id="add-cupos" type="button" class="btn btn-sm btn-success" >Añadir Cupos</button>
                            </div>
                        </div>
                    </div>

                </div>


            </div>




            <div class="col-md-12 col-sm-12" style="margin-top: 15px;">
                <div id='calendar' style="scroll-padding-top:0px; ">

                </div>
            </div>

            <div class="col-md-12 col-sm-12" style="margin-top: 25px;margin-bottom: 25px;">


                <div class="col-md-4 col-sm-3">

                </div>

                <div class="col-md-4 col-sm-6" style="text-align: center">

                    <?= Html::button('Cancelar', ['class' => 'btn btn-default', 'onclick' => 'window.history.go(-1)']) ?>

                    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary', 'id' => 'grabar']) ?>

                </div>

                <div class="col-md-4 col-sm-3">

                </div>


            </div>


        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php
$this->registerJsFile('@web/js/modules/rd/calendar/calendar.js', ['depends' => ['app\assets\CalendarAsset']]);
?>
