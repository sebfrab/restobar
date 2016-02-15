<?php
 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
 
?>
<div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
 
<!-- Render create form -->    
    <?= $this->render('_formDetalle', [
        'model' => $model,
    ]) ?>
 </div>
<div class='col-lg-8 col-md-6 col-sm-6 col-xs-12'>
    
    
<?php Pjax::begin(['id' => 'detalles']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'producto.nombre',
            'precio',
            'cantidad',
            [
                'attribute' => 'total',
                'value' => 'total',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['detalle/delete','id'=>$model->iddetalle]);
                        return Html::a('<span class="fa fa-search"></span>Delete',$url , [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',   
                            'data-method' => 'post'
                        ]);
            },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end() ?>
</div>


<?= Html::a('Cerrar mesa', ['/pedido/cerrar?id='.$pedido->idpedido], ['class'=>'btn btn-danger']) ?>