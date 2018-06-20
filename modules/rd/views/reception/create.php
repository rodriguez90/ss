<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */

$this->title = Yii::t('app', 'Nueva Importación');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Importaciones'), 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
