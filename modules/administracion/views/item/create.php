<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItem */

$this->title = 'Create Auth Item';
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
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


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
