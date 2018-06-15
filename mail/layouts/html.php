<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */

use app\assets\SystemAsset;
SystemAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?= Yii::$app->charset ?>"
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    <meta http-equiv="Content-Type" content="text/html; charset=--><?//= Yii::$app->charset ?><!--" />-->
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
    <div id="content" class="content">
        <?php $this->beginBody() ?>
        <?= $content ?>
        <?php $this->endBody() ?>
    </div>

<!--    <!-- begin footer -->-->
<!--    <div id="footer" class="footer">-->
<!--        &copy; --><?//= date('Y') ?><!-- Xedrux S.A | GUAYAQUIL Todos los Derechos Reservados.-->
<!--    </div>-->
<!--    <!-- end footer -->-->
    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>
</body>
</html>
<?php $this->endPage() ?>
