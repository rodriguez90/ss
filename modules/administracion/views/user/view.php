<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\administracion\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-md-8">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                                class="fa fa-expand"></i></a>

                </div>
                <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
            </div>
            <div class="panel-body">


                <p>
                    <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'username',
                        'nombre',
                        'apellidos',
                        'cedula',
                        'email:email',
                        // 'password',
                        //'authKey',

                        [
                            'attribute' => 'status',
                            'value' => ($model->status == 1)   ? 'Activo' : 'Inactivo',
                        ],
                        [
                            'label' => $model->attributeLabels()['created_at'],
                            'value' => (new \yii\i18n\Formatter())->asDate($model->created_at, 'Y/M/d'),
                        ],




                    ],
                    'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
                ]) ?>

            </div>
        </div>
    </div>
</div>
