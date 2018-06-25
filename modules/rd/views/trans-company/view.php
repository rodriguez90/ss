<?php

use app\modules\rd\models\TransCompanyPhone;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\TransCompany */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Compañías de Transporte', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                </div>
                <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
            </div>
            <div class="panel-body">
                <p>
                    <?= Html::a(Yii::t('app', 'Actualizar'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Eliminar'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Está seguro que desea eliminar la compañía de transporte?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'name',
            'ruc',
            'address:ntext',
            [
                'attribute' => 'active',
                'value' => ($model->active == 1)   ? 'Activa' : 'Inactiva',
            ],
            [
                'attribute' => 'phones',
                value => function($data){
                    $result = "";
                    $phones = TransCompanyPhone::findAll(['trans_company_id'=>$data['id']]);
                    $n = count($phones);
                    $i = 1;
                    foreach ($phones as $p){
                        if($i<$n)
                        $result .=  $p->phone_number." , ";
                        else
                            $result .=  $p->phone_number;
                        $i++;
                    }

                    return $result;
                },

            ]
        ],
        'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
    ]) ?>
            </div>
        </div>
    </div>
</div>
