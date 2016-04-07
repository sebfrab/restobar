<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Insumo */

$this->title = 'Update Insumo: ' . ' ' . $model->idinsumo;
$this->params['breadcrumbs'][] = ['label' => 'Insumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idinsumo, 'url' => ['view', 'id' => $model->idinsumo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="insumo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'stock' => $stock,
    ]) ?>

</div>
