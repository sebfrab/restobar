<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Subcategoria;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Producto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'precio',
            'descripcion:ntext',
            [
                'attribute'=>'subcategoria_idsubcategoria',
                'value' => 'subcategoria.nombre',
                'filter' => Html::activeDropDownList($searchModel, 'subcategoria_idsubcategoria', 
                        ArrayHelper::map(Subcategoria::find()->all(),'idsubcategoria','nombre'),
                        ['class' => 'form-control', 'prompt' => 'Todas']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>