<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\User */

$this->title = 'Nuevo Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<script type="text/javascript">
    var modelAux = null;
</script>

<div class="row">

    <?= $this->render('_form', [ 'model' => $model,'rol_actual'=>$rol_actual,'roles'=>$roles,'type'=>$type ]) ?>

</div>



