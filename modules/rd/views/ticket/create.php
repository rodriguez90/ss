<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Ticket */

$this->title = Yii::t('app', 'Asignación de Cupos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cupos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
