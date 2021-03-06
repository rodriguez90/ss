<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\administracion\models\AuthItemChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos';
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- begin row -->
<div class="row">
    <!-- begin col-6 -->
    <div class="col-md-6">
        <div class="panel panel-inverse" data-sortable-id="tree-view-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>

                </div>
                <h4 class="panel-title">Gestión de grupos</h4>
            </div>
            <div class="panel-body">
                <div id="jstree-default" >

                            <ul>
                                <?php
                                foreach($tree as $rol=>$permisos){

                                    echo "<li class='jstree-close' ><a class='parent' title='click para añadir permiso.'  href='".Url::toRoute(['/administracion/authitemchild/create','parent'=>  $rol])."' >".$rol."</a> ";
                                    $aux = $rol;
                                    foreach($permisos as $rol=> $permiso){

                                        echo "<ul>";
                                        echo "<li>  <a href='".Url::toRoute(['/administracion/authitemchild/delete','parent'=>  $aux,'child'=> $permiso['child']])."'  title=\"Click para eliminar permiso.\" aria-label=\"Eliminar\" data-pjax=\"0\" data-confirm=\"¿Está seguro de eliminar este elemento?\" data-method=\"post\"> ". $permiso['child']  ."</a></li>";
                                        echo "</ul>";
                                    }

                                echo " </li>";

                                }
                                //fa-group
                                //fa-unlock
                                //echo "<li data-jstree='{'opened':true, 'selected':true }'>Initially Selected</li>"

                                ?>
                                <!--li data-jstree='{"opened":true}' >
                                    Initially open
                                    <ul>
                                        <li data-jstree='{"disabled":true}' >Disabled node</li>
                                        <li>Another node</li>
                                    </ul>
                                </li-->
                                <!--li data-jstree='{ "icon" : "fa fa-warning fa-lg text-danger" }'>custom icon class (fontawesome)</li>
                                <li data-jstree='{ "icon" : "fa fa-link fa-lg text-primary" }'><a href="http://www.jstree.com">Clickable link node</a></li-->
                            </ul>

                </div>
            </div>
        </div>
    </div>

    </div>

    <?php
    $this->registerJsFile('@web/js/modules/administracion/tree.js', ['depends' => ['app\assets\AppAsset']]);
    ?>

