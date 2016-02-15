<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ubicacion */

$this->title = 'Update Ubicacion: ' . ' ' . $model->idubicacion;
$this->params['breadcrumbs'][] = ['label' => 'Ubicacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idubicacion, 'url' => ['view', 'id' => $model->idubicacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ubicacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
