<?php
    use yii\helpers\Html;
?>

<div class="row">
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
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="pull-right">
            <?= Html::a('Cerrar mesa', 
              ['mesa/cerrarmesa?id='.$model->idpedido], ['class' => 'showModalButton btn btn-lg btn-danger', 'id'=>'button-adicionar', 'title' => 'Cerrar '.$model->mesa->nombre]) ?>
        </div>
    </div>
</div>