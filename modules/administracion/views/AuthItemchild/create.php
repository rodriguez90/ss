<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItemChild */

$this->title = 'Asignar permiso';
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-create">

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


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
