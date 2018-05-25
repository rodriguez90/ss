<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Container */

$this->title = 'Nuevo';
$this->params['breadcrumbs'][] = ['label' => 'Contenedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
