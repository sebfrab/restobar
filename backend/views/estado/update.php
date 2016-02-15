<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Estado */

$this->title = 'Update Estado: ' . ' ' . $model->idestado;
$this->params['breadcrumbs'][] = ['label' => 'Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idestado, 'url' => ['view', 'id' => $model->idestado]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estado-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
