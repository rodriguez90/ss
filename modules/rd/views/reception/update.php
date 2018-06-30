<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rd\models\Reception */

$this->title = Yii::t('app', 'Actualizar Reception: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Recepciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
?>
<div class="reception-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script type="text/javascript">
    var modelId = '<?php echo $model->id; ?>';
    var transCompany =  '<?php echo $model->transCompany->name; ?>';
    var bl =  '<?php echo $model->bl; ?>';
</script>
