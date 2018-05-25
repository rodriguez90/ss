<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Container */

$this->title = 'Update Container: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contenedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
