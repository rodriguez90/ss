<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
//use app\assets\AppAsset;
use app\assets\SystemAsset;

//AppAsset::register($this);
SystemAsset::register($this)
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

<div class="wrap">
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Inicio', 'url' => ['/site/index']],
                ['label' => 'Acerca ?', 'url' => ['/site/about']],
                ['label' => 'Contactenos', 'url' => ['/site/contact']],
                Yii::$app->user->isGuest ? (
                    ['label' => 'Entrar', 'url' => ['/site/login']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/site/logout'], 'post')
                    . Html::submitButton(
                        'Salir (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
            ],
        ]);

        NavBar::end();
        ?>

    <!--begin sidebar-->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar nav -->
                <ul class="nav">
                    <li class="nav-profile">
                        <div class="image">
                            <a href="javascript:;"><img src="/img/user-13.jpg" alt="" /></a>
                        </div>
                        <div class="info">
                            User Name
                            <small>Company Name</small>
                        </div>
                    </li>
                    <li class="has-sub">
                        <a href="<?php use yii\helpers\Url; echo Url::to(['/rd/warehouse']);?>"/> <i class="fa fa-building"></i>
                            <span> Depósito</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="/rd/agency"> <i class="fa fa-institution alias"></i>
                            <span> Agencias</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="/rd/container"> <i class="fa fa-cubes"></i>
                            <span> Contenedores</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="/rd/trans-company"> <i class="fa fa-truck"></i>
                            <span> Transporte</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="javascript:;"> <i class="fa fa-file-o"></i>
                            <span> Recepción</span>
                        </a>
                    </li>
                    <li class="has-sub">
                        <a href="javascript:;"> <i class="fa fa-ticket"></i>
                            <span> Despacho</span>
                        </a>
                    </li>
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

        <div id="content" class="content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>

        <!-- begin #footer -->
        <div id="footer" class="footer">
            &copy; <?= date('Y') ?> Xedrux S.A | GUAYAQUIL Todos los Derechos Reservados.
        </div>
        <!-- end #footer -->

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
