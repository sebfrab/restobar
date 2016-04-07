<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Producto */

$this->title = $producto->idproducto;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>





<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #000; margin-bottom: 15px;">
    <h4>Producto: <?php echo $producto->nombre; ?></h4>
    <p style="color: #585858;">
        <b>Precio :</b> $ <?= number_format($producto->precio, 0, ",", "."); ?>  
        <b>Precio Descuento: </b> $ <?= number_format($producto->precio_descuento, 0, ",", "."); ?>   
        <b>Subcategoria: </b> <?= $producto->subcategoria->nombre; ?>
    </p>
    <p>
        <b>Tipo: </b> <?= $producto->tipoProducto->nombre; ?> 
        <?php if($producto->tipo_producto_idtipo_producto == 0){?>
        <b>Stock: </b> <?= $producto->stock->stock;?>
        <?php } ?>
    </p>
    
    <p class="pull-right">
        <?= Html::a('Actualizar', ['update', 'id' => $producto->idproducto], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
<?php if($producto->tipo_producto_idtipo_producto != 0){?>
<?php Pjax::begin(['id'=>'insumosGridview']); ?>

<?php
$script = <<< JS
$('.removeinsumo').click(function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    $.ajax({
        url: url,
        success: function(response) {
            if(response == 'success'){
                toastr.success('Insumo eliminado del producto');
                $.pjax.reload({container: '#insumosGridview'});
            }else{
                alert("Error en eliminar insumo del producto");
            }
       }
    });
});
JS;
$this->registerJs($script);
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            [                      
                'label' => 'cantidad',
                'value' => function($data) use ($producto){
                    $cantidad =  \common\models\Insumo::getCantidadInsumoProducto($data->idinsumo, $producto->idproducto);
                    if($cantidad > 0){
                         return $cantidad. ' '. $data->stock->unidadMedida->abreviacion ;
                    }else{
                        return '';
                    }
                }

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{addinsumo}{removeinsumo}',
                'buttons' => [
                    'addinsumo' => function ($url,$model, $key)  use ($producto){
                        if($model->getInProducto($producto->idproducto) == null){
                            $url = Url::to(['producto/addinsumo','id'=>$producto->idproducto,'idinsumo'=>$key]);
                            return Html::a('<span class="glyphicon glyphicon-plus"></span>',$url , [
                                    'title' => Yii::t('app', 'agregar insumo | '.$model->nombre),
                                    'class'=>'btn btn-success btn-xs showModalButton',   
                                ]);
                        }
                    },
                    'removeinsumo' => function ($url,$model, $key)  use ($producto){
                        if(!$model->getInProducto($producto->idproducto) == null){
                            $url = Url::to(['producto/removeinsumo','id'=>$producto->idproducto,'idinsumo'=>$key]);
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>',$url , [
                                    'title' => Yii::t('app', 'quitar insumo | '.$model->nombre),
                                    'class'=>'btn btn-danger btn-xs removeinsumo',   
                                ]);
                        }                      
                    }                 
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
<?php } ?>
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