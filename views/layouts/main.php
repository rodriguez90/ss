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
use app\modules\rd\models\Process;

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

    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin page container -->
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
                <?php
                    if($user)
                    {

                       echo '<ul class="nav navbar-nav navbar-right">';
                            echo '<li class="dropdown navbar-user">';
                                echo '<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">';
                                    echo '<img src="/img/user-13.jpg" alt="" />';
                                    echo '<span class="hidden-xs">';
                                        if(!Yii::$app->user->isGuest && user !== null)
                                            echo $user->username;

                                    echo '</span> <b class="caret"></b>';
                                echo '</a>';
                        echo '<ul class="dropdown-menu animated fadeInLeft">';
                            echo '<li class="arrow"></li>';
                            echo '<li><a href="javascript:;">Editar Perficl</a></li>';
                            echo '<li><a href="javascript:;">Configuraciones</a></li>';
                            echo '<li class="divider"></li>';


                            if(!Yii::$app->user->isGuest ){
                                echo("<li><a href='". Url::to(["/site/logout"]). "'> Salir</a></li>");
                            }

                        echo '</ul>';
                        echo '</li>';
                        echo '</ul>';
                    }
                ?>
                <!-- end header navigation right -->

            </div>
        </div>

    <!--begin sidebar-->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar nav -->
                <ul class="nav" style="font-size: 14px">

                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("process_create")){
                        echo "<li class='has-sub'>";
                        echo "<a href=".Url::to(['/rd/process/create','type'=>Process::PROCESS_IMPORT])."> <i class='fa fa-rotate-90 fa-sign-in'></i>";
                        echo  "<span> Importación</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("process_create")){
                        echo "<li class='has-sub'>";
                        echo "<a href=".Url::to(['/rd/process/create','type'=>Process::PROCESS_EXPORT])."> <i class='fa fa-rotate-90 fa-sign-in'></i>";
                        echo  "<span> Exportación</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>
                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("process_create")){
                        echo "<li class='has-sub'>";
                        echo "<a href=".Url::to(['/site/report'])."> <i class='fa fa-file-pdf-o'></i>";
                        echo  "<span> Reporte</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>

                    <?php
                    if(Yii::$app->user->can("ticket_create")){
                        echo "<li class='has-sub'>";
                        echo "<a href=".Url::to(['/rd/ticket/my-calendar'])."> <i class='fa fa-calendar'></i>";
                        echo  "<span> Mi Calendario</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                    ?>

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

<!--                    --><?php
//                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("container_list")){
//                        echo "<li class='has-sub'>";
//                        echo "<a href=". Url::to(['/rd/container'])."> <i class='fa fa-cubes'></i>";
//                        echo "<span> Contenedores</span>";
//                        echo "</a>";
//                        echo "</li>";
//                    }
//                    ?>

                    <?php
                    if(Yii::$app->user->can("admin_mod") || Yii::$app->user->can("trans-company_list")){
                        echo "<li class='has-sub'>";
                        echo "<a href=" . Url::to(['/rd/trans-company'])."> <i class='fa fa-truck'></i>";
                        echo "<span> Transporte</span>";
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

                    if (Yii::$app->user->can("admin_mod") || Yii::$app->user->can("generating_card")) {
                        echo "<li class='has-sub'>";
                        echo "<a href=" . Url::to(['/rd/process/generatingcard']) . "> <i class='fa fa-credit-card'></i>";
                        echo "<span> Carta de Servicio</span>";
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

<script type="text/javascript">
    var homeUrl = '<?php echo Yii::$app->homeUrl; ?>';
</script>

<!-- end wrap -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
