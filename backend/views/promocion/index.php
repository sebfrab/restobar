<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Estado;

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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            [
                'attribute'=>'estado_idestado',
                'value' => 'estado.nombre',
                'filter' => Html::activeDropDownList($searchModel, 'estado_idestado', 
                        ArrayHelper::map(Estado::getEstadosTrueFalse(),'idestado','nombre'),
                        ['class' => 'form-control', 'prompt' => 'Todas']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
