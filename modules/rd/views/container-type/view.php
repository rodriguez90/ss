<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\ContainerType */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tipos de Contenedores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-type-view">

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
                        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Está seguro que desea eliminar la agencia?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'code',
                            'tonnage',
                            [
                                'attribute' => 'active',
                                'value' => ($model->active == 1)   ? 'Activo' : 'Inactivo',
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
