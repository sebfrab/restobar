<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Subcategoria */

$this->title = 'Update Subcategoria: ' . ' ' . $model->idsubcategoria;
$this->params['breadcrumbs'][] = ['label' => 'Subcategorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idsubcategoria, 'url' => ['view', 'id' => $model->idsubcategoria]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subcategoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
