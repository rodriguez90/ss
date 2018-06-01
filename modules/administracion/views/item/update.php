<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\AuthItem */

$this->title = $type == 1 ? 'Actualizar Rol':'Actualizar Permiso';
$this->params['breadcrumbs'][] = ['label' => $type == 1 ? 'Gestión de Roles' : 'Gestión de Permisos', 'url' => ['index','type'=>$type]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="auth-item-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
