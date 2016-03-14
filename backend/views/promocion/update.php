<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Promocion */

$this->title = 'Actualizar Promoción: ' . ' ' . $model->idpromocion;
$this->params['breadcrumbs'][] = ['label' => 'Promociones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idpromocion, 'url' => ['view', 'id' => $model->idpromocion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promocion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
