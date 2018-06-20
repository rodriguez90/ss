<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Process */

$this->title = Yii::t('app', 'Nueva Importación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Importaciones/Exportaciones'), 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="process-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
