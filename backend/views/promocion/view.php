<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = ['label' => 'Promociones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$url = Url::to(['/promocion/view', 'id' => $promocion->idpromocion]);
$script = <<< JS
    
$('.eliminar').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        data: '',
        success: function(response) {
            if(response == 'success'){
                window.location.href = '$url';
            }else{
                alert("Error al eliminar el producto de la promoción");
            }
        }
    });
});
        
$('.adicionar').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        data: '',
        success: function(response) {
            if(response == 'success'){
                window.location.href = '$url';
            }else{
                alert("Producto Agregado");
            }
        }
    });
});
JS;
$this->registerJs($script);
?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #000; margin-bottom: 15px;">
    <h4>Promoción: <?php echo $promocion->nombre; ?></h4>
    <p style="color: #585858;">
        <b>% descuento:</b> <?= $promocion->porcentaje_descuento; ?> % 
        <b>Hora inicio:</b> <?= $promocion->hora_inicio; ?> 
        <b>Hora termino:</b> <?= $promocion->hora_fin; ?>
    </p>
    <p>
        <?php
            $class_true = "glyphicon glyphicon-ok";
            $class_false = "glyphicon glyphicon-remove";
        ?>
        Lunes <?php if($promocion->lunes){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span> 
        Martes <?php if($promocion->martes){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span> 
        Miercoles <?php if($promocion->miercoles){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span> 
        Jueves <?php if($promocion->jueves){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span>  
        Viernes <?php if($promocion->viernes){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span> 
        Sábado <?php if($promocion->sabado){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span> 
        Domingo <?php if($promocion->domingo){$class = $class_true;}else{$class = $class_false;} ?> <span class="<?= $class ?>"></span> 
    </p>
    
    <p class="pull-right">
        <?= Html::a('Actualizar', ['update', 'id' => $promocion->idpromocion], ['class' => 'btn btn-primary']) ?>
    </p>
</div>




<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'precio',
            'subcategoria.nombre',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{addproduct}{removeproduct}',
                'buttons' => [
                    'addproduct' => function ($url,$model, $key)  use ($promocion){
                        if( $model->getInPromocion($promocion->idpromocion) == null){
                            $url = Url::to(['promocion/addproduct','id'=>$promocion->idpromocion,'idproducto'=>$model->idproducto]);
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>',$url , [
                                'title' => Yii::t('app', 'agregar a promoción'),
                                'class'=>'btn btn-success btn-xs adicionar',   
                                'data-method' => 'post'
                            ]);
                        }  
                    },
                    'removeproduct' => function ($url,$model, $key)  use ($promocion){
                        
                        if( $model->getInPromocion($promocion->idpromocion) != null){
                            $url = Url::to(['promocion/removeproduct','id'=>$promocion->idpromocion, 'idproducto'=>$model->idproducto]);
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>',$url , [
                                'title' => Yii::t('app', 'quitar de promoción'),
                                'class'=>'btn btn-danger btn-xs eliminar',   
                                'data-method' => 'post'
                            ]);
                        }
                        
                    }        
                            
                            
                ],
            ],
        ],
    ]); ?>
