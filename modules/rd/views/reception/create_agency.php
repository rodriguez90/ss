<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */

$this->title = Yii::t('app', 'Create Reception');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Receptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reception-create">

    <?= $this->render('_formAgency', [
        'model' => $model,
    ]) ?>

</div>
