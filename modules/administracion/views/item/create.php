<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItem */

$this->title = $type == 1 ? 'Nuevo Rol':'Nuevo Permiso';
$this->params['breadcrumbs'][] = ['label' => $type == 1 ? 'Gestión de Roles' : 'Gestión de Permisos', 'url' => ['index','type'=>$type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create">

    <?php if ($model->hasErrors())
    { ?>
        <section>
            <?php foreach ($model->errors as $key => $value)
            {
                ?>
                <div class="alert-danger padding-5 font-md">
                    <i class="fa fa-warning"></i> <?= $value[0]; ?>
                </div>
            <?php } ?>
        </section>
    <?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
