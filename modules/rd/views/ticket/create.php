<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Ticket */

$this->title = Yii::t('app', 'Reservar Cupos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
