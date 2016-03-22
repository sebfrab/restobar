<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Categoria;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subcategorias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategoria-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Subcategoria', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            [
                'attribute'=>'categoria_idcategoria',
                'value' => 'categoria.nombre',
                'filter' => Html::activeDropDownList($searchModel, 'categoria_idcategoria', 
                        ArrayHelper::map(Categoria::find()->all(),'idcategoria','nombre'),
                        ['class' => 'form-control', 'prompt' => 'Todas']),
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
