<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class='pull-right'>
        <?= Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> imprimir Comanda', ['#'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar', 
                'adicionar?id='.$pedido->idpedido, ['class' => 'showModalButton btn btn-success' , 'title'=>'Adicionar - '.$pedido->mesa->nombre]) ?>
    </div>
</div>

<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
    
<?php Pjax::begin(['id' => 'detalles']) ?>
    <?= GridView::widget([
        //'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'pager' => [
            'firstPageLabel' => 'Primera',
            'lastPageLabel' => 'ultima',
        ],
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
                'contentOptions'=>['style'=>'width: 20px;'],
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['pedido/remove','id'=>$model->iddetalle]);
                        return Html::a('<i class="glyphicon glyphicon-remove"> </i>',$url , [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-danger btn-small',   
                            'data-method' => 'post'
                        ]);
            },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end() ?>
</div>


<?php
    Modal::begin([
        'header' => '<span id="modalHeaderTitle"></span>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ],
        'id' => 'modal',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
?>