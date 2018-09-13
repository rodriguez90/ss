<?php

use yii\helpers\Html;
use app\modules\rd\models\Process;


/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Process */

$this->title = Yii::t('app', 'Nueva ' . Process::PROCESS_LABEL[$type]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Procesos'), 'url' => ['/site/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="process-create">

    <?= $this->render('_form_five_steps', [
        'model' => $model,
        'type'=>$type,
        'agencyId'=>$agencyId
    ]) ?>

</div>
