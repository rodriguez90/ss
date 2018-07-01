<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\FormAsset;
FormAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\ContainerType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container-type-form">

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

    <?php $form = ActiveForm::begin([
        'id' => 'agency-form',
        'class'=>'form-horizontal',
        'enableClientScript' => false,
        'options' =>
            [
                'data-parsley-validate' => true
            ],
    ]); ?>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Nombre</label>
        <div class="col-md-9">
            <?= $form->field($model, 'name')->textInput(['class' => 'form-control' , 'data-parsley-required'=>"true",  ])->label(false) ?>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Código</label>
        <div class="col-md-9">
            <select class="combobox form-control" name="ContainerType[code]">
                <option value="">Seleccione Código</option>
                <option value="DRY" <?php echo $model->code == 'DRY' ? "selected=''": "" ?>>DRY</option>
                <option value="RRF" <?php echo $model->code == 'RRF' ? "selected=''": "" ?>>RRF</option>
            </select>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Toneladas</label>
        <div class="col-md-9">
            <?= $form->field($model, 'tonnage')
                        ->textInput([
                                    'data-parsley-required'=>"true",
                                    'id'=>'default_rangeSlider',
                                    'value'=>$model->isNewRecord ?20:$model->tonnage,
                                    'name'=>"ContainerType[tonnage]"])->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label">Activo</label>
        <div class="col-md-9">
            <?= $form->field($model, 'active')->checkbox(['data-render' => "switchery",'checked'=>$model->isNewRecord ? 'checked=""' : ''], false)->label(false) ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 col-sm-3 control-label"></label>
        <div class="col-md-9">
            <?= Html::button('Cancelar', ['class' => 'btn btn-default', 'onclick' => 'window.history.go(-1)']) ?>
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJsFile('@web/js/modules/rd/container/container-type-create.js', ['depends' => ['app\assets\FormAsset']]) ?>



<script type="text/javascript">
    var modelTonnage = '<?php echo $model->tonnage; ?>';
</script>

