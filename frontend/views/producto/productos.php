<?php
use yii\bootstrap\Modal;
use yii\helpers\Url;  
?>


<?php
$url = Url::to(['/producto/listproductos']);
$script = <<< JS
    
$('.btn-categoria').on('click', function(e) {
    $("#list-productos").html("");
    var idcategoria = $(this).val()
    $.ajax({
       url: '$url',
       data: {idcategoria: idcategoria},
       success: function(data) {
           $("#list-productos").html(data);
       }
    });
});
JS;
$this->registerJs($script);
?>


<?php
$url = Url::to(['/pedido/admin', 'id'=>$pedido->idpedido]);
?>
<div class="row">
    <div class="col-lg-12" style="margin-bottom: 40px;">
        <a href="<?php echo $url; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-chevron-left"></span>volver</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="btn-group" role="group" aria-label="...">
            <?php
                foreach($model as $categoria){
            ?>
                    <button value="<?php echo $categoria->idcategoria; ?>" type="button" class="btn btn-default btn-lg btn-categoria">
                        <?php echo $categoria->nombre; ?>
                    </button>
            <?php
                }
            ?>
        </div>
    </div>
</div>


<div id="list-productos">

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
