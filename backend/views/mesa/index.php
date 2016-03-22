<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mesas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mesa-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mesa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            [
                'attribute'=>'ubicacion_idubicacion',
                'value' => 'ubicacion.nombre',
                'filter' => Html::activeDropDownList($searchModel, 'ubicacion_idubicacion', 
                        ArrayHelper::map(Ubicacion::find()->all(),'idubicacion','nombre'),
                        ['class' => 'form-control', 'prompt' => 'Todas']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
