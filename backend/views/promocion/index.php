<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promociones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promocion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingresar Promoción', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idpromocion',
            'nombre',
            'porcentaje_descuento',
            'hora_inicio',
            'hora_fin',
            // 'lunes',
            // 'martes',
            // 'miercoles',
            // 'jueves',
            // 'viernes',
            // 'sabado',
            // 'domingo',
            // 'estado_idestado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
