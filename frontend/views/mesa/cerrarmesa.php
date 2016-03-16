<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
?>


<?php
$_csrf = Yii::$app->request->getCsrfToken();
$url = Url::toRoute("mesa/index") ;
$js = <<<JS
$('#button-cerrar').click(function(e) {
        
    e.preventDefault();
    var data = {'Pedido[idpedido]': $model->idpedido};
    $.ajax({
      url: $(this).attr('href'),
      type: 'post',
      data: data,
      success: function(response) {
        if(response == 'success'){
            window.location.href = '$url';
        }else{
            alert("Error en cerrar mesa");
        }
      }
    });
   
});
JS;
 
$this->registerJs($js);
?>



<div class="row">
    <?php
    if(count($model->detallesPendiente) > 0){
    ?>
        <div class="alert alert-danger" role="alert">
            <p>Existen <b>Adiciones pendientes</b>, 
                favor de confirmar las adiciones para poder cerrar la mesa</p>
        </div>
    <?php } ?>
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4>Adiciones</h4>
        <div class="panel panel-default">
            <table class="table">
                <tr>   
                  <th>Producto</th>
                </tr>
              <?php
                $realizado = null;
                if(isset($model->detallesRealizado)){
                    $realizado = $model->detallesRealizado;
                }
                  foreach($realizado as $detalle){ 
                ?>
                <tr>
                    <td>
                        <?php echo $detalle->producto->nombre; ?>
                    </td>

                    <td style="width: 90px;">
                         <?php echo number_format($detalle->precio, 0, ",", "."); ?>
                         x 
                        <?php echo $detalle->cantidad;?>
                    </td>
                    <td> <b>$ <?php echo number_format($detalle->getTotal(), 0, ",", ".");?></b></td>
                </tr>

                <tr>
                    <td colspan="3" class="comentario">
                        <?php echo $detalle->comentario; ?>
                    </td>
                </tr>

              <?php        
                  }
              ?>
                <tr style="background-color: #f0eef0;">
                    <td colspan="2">
                        <b>Total</b>
                    </td>
                    <td>
                        <b>$ <?= number_format($model->totalPedido, 0, ",", "."); ?></b>
                    </td>
                </tr>
            </table>
        </div>
        
    </div>
    <?php
    if(count($model->detallesPendiente) == 0){
    ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="pull-right">
            <?= Html::a('Cerrar mesa', 
              ['mesa/cerrarmesa?id='.$model->idpedido], ['class' => 'btn btn-lg btn-danger', 'id'=>'button-cerrar', 'title' => 'Cerrar '.$model->mesa->nombre]) ?>
        </div>
    </div>
    <?php } ?>
</div>