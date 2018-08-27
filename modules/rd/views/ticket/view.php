<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Ticket */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'process_transaction_id',
            'calendar_id',
            'status',
            'created_at',
            'active',
        ],
    ]) ?>

</div>
