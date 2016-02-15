<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Mesa */

$this->title = 'Update Mesa: ' . ' ' . $model->idmesa;
$this->params['breadcrumbs'][] = ['label' => 'Mesas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idmesa, 'url' => ['view', 'id' => $model->idmesa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mesa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
