<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\administracion\models\AdmUser;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\SystemAsset;

SystemAsset::register($this);

$user = null;
//$userName = "Invitado";
if(!Yii::$app->user->isGuest){
    $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!--<div class="wrap">-->

    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

        <div id="header" class="header navbar navbar-default navbar-fixed-top">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="<?php echo Yii::$app->homeUrl ?>" class="navbar-brand"><span class="navbar-logo"></span> <?php echo Yii::$app->name ?></a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->

                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown navbar-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/user-13.jpg" alt="" />
                            <span class="hidden-xs">

                                <?php
                                if($user)
                                    echo $user->username;
                                ?>

                            </span> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                            <li><a href="javascript:;">Editar Perficl</a></li>
                            <li><a href="javascript:;">Configuraciones</a></li>
                            <li class="divider"></li>

                            <?php
                            if(Yii::$app->user->isGuest ){
                                echo("<li><a href='". Url::to(["/site/login"]). "'> Login</a></li>");
                            }else{
                                echo("<li><a href='". Url::to(["/site/logout"]). "'> Salir</a></li>");
                            }
                            ?>

                        </ul>
                        <!-- end header navigation right -->
                    </li>
                </ul>


            </div>
        </div>

    <!--begin sidebar-->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar nav -->
                <ul class="nav">
                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("warehouse_list") ){
                        echo "<li class='has-sub'>";
                        echo "<a href=" . Url::to(['/rd/warehouse'])."/> <i class='fa fa-building'></i>";
                        echo "<span> Depósito</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can("admin_mod")  || Yii::$app->user->can("agency_list") ){
                        echo "<li class='has-sub'>";
                        echo "<a href=" . Url::to(['/rd/agency']) ."> <i class='fa fa-institution alias'></i>";
                        echo "<span> Agencias</span>";
                        echo "</a>";
                        echo "</li>";
                      }
                    ?>

                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("container_list")){
                        echo "<li class='has-sub'>";
                        echo "<a href=". Url::to(['/rd/container'])."> <i class='fa fa-cubes'></i>";
                        echo "<span> Contenedores</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("trans-company_list")){
                        echo "<li class='has-sub'>";
                        echo "<a href=" . Url::to(['/rd/trans-company'])."> <i class='fa fa-truck'></i>";
                        echo "<span> Transporte</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>
                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("reception_create")){
                        echo "<li class='has-sub'>";
                        echo "<a href=".Url::to(['/rd/reception/create'])."> <i class='fa fa-rotate-90 fa-sign-in'></i>";
                        echo  "<span> Recepción</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>


                    <!--                    <li class="has-sub">-->
                    <!--                        <a href="javascript:;"> <i class="fa fa-rotate-90 fa-sign-out"></i>-->
                    <!--                            <span> Despacho</span>-->
                    <!--                        </a>-->
                    <!--                    </li>

                    <!---->
<!--                    <li class="has-sub">-->
<!--                        <a href="javascript:;"> <i class="fa fa-rotate-90 fa-sign-out"></i>-->
<!--                            <span> Despacho</span>-->
<!--                        </a>-->
<!--                    </li>-->

                    <?php
                    if (Yii::$app->user->can("admin_mod") || Yii::$app->user->can("calendar_list")) {
                        echo "<li class='has-sub'>";
                        echo "<a href=" . Url::to(['/rd/calendar']) . "> <i class='fa fa-calendar'></i>";
                        echo "<span> Calendario</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>

                    <?php
                        if(Yii::$app->user->can("admin_mod")){
                           echo "<li class='has-sub'>";
                           echo "<a href='javascript:;'> <b class='caret pull-right'></b> <i class='fa fa-cog'></i> <span>Administración</span> </a>";
                           echo "<ul style='' class='sub-menu'>";
                           echo "<li><a href=". Url::toRoute(['/administracion/user']) .">Usuarios</a></li>";
                           echo "<li><a href=". Url::toRoute(['/administracion/item','type'=> 1]) .">Roles</a></li>";
                           echo "<li><a href=". Url::toRoute(['/administracion/item','type'=> 2]) .">Permisos</a></li>";
                           echo "<li><a href=". Url::toRoute(['/administracion/authitemchild/']) .">Grupos</a></li>";
                           echo "</ul>";
                           echo "</li>";
                        }
                    ?>

                    <!-- begin sidebar minify button -->
                    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                    <!-- end sidebar minify button -->
                </ul>
                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
        </div>
        <div class="sidebar-bg"></div>
    <!--end sidebar-->

        <!-- begin conten -->
        <div id="content" class="content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        <!-- end conten -->

        <!-- begin footer -->
        <div id="footer" class="footer">
            &copy; <?= date('Y') ?> Xedrux S.A | GUAYAQUIL Todos los Derechos Reservados.
        </div>
        <!-- end footer -->

        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->

    </div>
    <!-- end page container -->
<!--</div>-->


<script type="text/javascript">
    var homeUrl = '<?php echo Yii::$app->homeUrl; ?>';
</script>

<!-- end wrap -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
