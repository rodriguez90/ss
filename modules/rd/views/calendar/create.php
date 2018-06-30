<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Calendar */

$this->title = Yii::t('app', 'Gestión de calendario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Calendars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
