<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Promocion */

$this->title = $model->idpromocion;
$this->params['breadcrumbs'][] = ['label' => 'Promocions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idpromocion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idpromocion], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idpromocion',
            'nombre',
            'porcentaje_descuento',
            'hora_inicio',
            'hora_fin',
            'lunes',
            'martes',
            'miercoles',
            'jueves',
            'viernes',
            'sabado',
            'domingo',
            'estado_idestado',
        ],
    ]) ?>

</div>
