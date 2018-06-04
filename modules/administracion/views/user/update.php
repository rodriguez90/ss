<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\User */

$this->title = 'Actualizar Usuario ';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Actualizar Usuario';
?>
<div class="user-update">


    <?= $this->render('_form', [
        'model' => $model,'rol_actual'=>$rol_actual,'roles'=>$roles,'type'=>$type
    ]) ?>

</div>
