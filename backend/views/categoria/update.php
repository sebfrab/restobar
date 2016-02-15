<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Categoria */

$this->title = 'Update Categoria: ' . ' ' . $model->idcategoria;
$this->params['breadcrumbs'][] = ['label' => 'Categorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcategoria, 'url' => ['view', 'id' => $model->idcategoria]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
