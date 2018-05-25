<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\TransCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Compañias de Transporte', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trans-company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'ruc',
            'address:ntext',
            'active',
        ],
    ]) ?>

</div>
