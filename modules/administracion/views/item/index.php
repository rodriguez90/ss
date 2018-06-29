<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\administracion\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $type == 1 ? 'Gestión de Roles':'Gestión de Permisos';
$this->params['breadcrumbs'][] = $this->title;


//<?= $tab == 1 ? 'active' : ''

//<?= $tab == 1 ? 'tab-pane fade active in' : 'tab-pane fade'

?>



<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                            class="fa fa-expand"></i></a>

                </div>
                <h4 class="panel-title"><?= Html::encode($this->title) ?></h4>

            </div>
            <div class="panel-body">
                <div class="dataTables_wrapper form-inline dt-bootstrap no-footer" id="data-table_wrapper">

                    <p>
                        <?= Html::a( $type == 1 ? 'Nuevo Rol': 'Nuevo Permiso'  , ['create','type'=>$type], ['class' => 'btn btn-success']) ?>
                    </p>

                    <div class="table-responsive">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],
                            ['attribute' => 'name','label'=>'Nombre'],
                             /* ['attribute' => 'type','label' => 'Tipo','content' => function ($data)  {
                                        return $data->type == 1 ? 'Rol' : 'Permiso';
                                    } ],*/
                            ['attribute' => 'description','label'=>'Descripción'],
                            //'created_at',
                            //'updated_at',

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Acciones',
                                'template' => '{delete}']
                            ],
                    ]); ?>

                    </div>

                </div>
             </div>
         </div>
     </div>
</div>



