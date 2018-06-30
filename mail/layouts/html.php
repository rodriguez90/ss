<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
/* @var $model app\modules\rd\models\Reception */

use yii\widgets\DetailView;
use app\assets\FormAsset;
use app\assets\TableAsset;
use app\assets\WizardAsset;
use app\modules\rd\models\Container;
use yii\helpers\Url;
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
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }

        /* RESET STYLES */
        img { border: 0; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { margin: 0 !important; padding: 0 !important; width: 100% !important; }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] { margin: 0 !important; }

        /* MEDIA QUERIES */
        @media all and (max-width:639px){
            .wrapper{ width:320px!important; padding: 0 !important; }
            .container{ width:300px!important;  padding: 0 !important; }
            .mobile{ width:300px!important; display:block!important; padding: 0 !important; }
            .img{ width:100% !important; height:auto !important; }
            *[class="mobileOff"] { width: 0px !important; display: none !important; }
            *[class*="mobileOn"] { display: block !important; max-height:none !important; }
        }
        .jumbotron {
            padding-right: 60px;
            padding-left: 60px;
            border-radius: 6px;
            margin-bottom: 30px;
            color: inherit;
            background-color: #eee;
            padding-top: 48px;
            padding-bottom: 48px;
        }
        @media screen and (min-width: 768px)
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<!--        --><?//= $content ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">

    <tr>
        <td align="center" valign="top">
            <div class="jumbotron">
                <h3 style="margin:0; padding:0; margin-bottom:15px;">Notificación de nueva recepción</h3>
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" valign="top">


    <tr>
        <td align="center" valign="top">
            <h4 style="margin:0; padding:0; margin-bottom:15px;">Detalles de la Recepción</h4>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //                       'id',
                    [
                        'attribute'=>'id',
                        'label'=>'No.',
                    ],
                    'bl',
                    'created_at:datetime',
                    [
                        'attribute'=>'transCompany',
                        'value'=>$model->transCompany->name
                    ],
                    [
                        'attribute'=>'agency',
                        'value'=>$model->agency->name
                    ],
                    [
                        'attribute'=>'active',
                        'value'=>$model->active ? 'Si':'No'
                    ],
                    [
                        'label'=>'Cantidad de Contenedores',
                        'value'=>count($model->receptionTransactions)
                    ]
                ],
                'options'=>['class' => 'table table-striped table-bordered table-condensed detail-view'],
            ]) ?>
        </td>
    </tr>

    <tr>
        <td align="center" valign="top">
            <h4 style="margin:0; padding:0; margin-bottom:15px;">Contenedores</h4>
            <?php
            $result = Html::ul($containers, ['item' => function($item, $index) {
                    $li = Html::tag(
                        'li',
                        Html::encode($item['name'] . ' '. $item['type'] . ' ' . $item['tonnage']),
                        []
                    );
                    //                                        var_dump($li) ; die;
                    return $li;
                }])

                . Html::endTag('div');
            echo $result;
            ?>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top">
            <table width="200" height="44" cellpadding="0" cellspacing="0" border="0" bgcolor="#2b3a63" style="border-radius:4px;">
                <tr>
                    <td align="center" valign="middle" height="44" style="font-family: Arial, sans-serif; font-size:14px; font-weight:bold;">
                        <a href="<?php echo Url::to(['/rd/reception/trans-company', 'id'=>$model->id], true);?>" target="_blank" style="font-family: Arial, sans-serif; color:#ffffff; display: inline-block; text-decoration: none; line-height:44px; width:200px; font-weight:bold;">Reservar Cupos</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </td>
    </tr>
</table>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
