<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #000; margin-bottom: 15px;">
    <h4><?php echo $model->mesa->nombre; ?></h4>
    <p style="color: #585858;"><?php echo $model->comentario; ?></p>
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class='pull-right hidden-xs'>
        
        <?= Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span> imprimir Comanda', 
                ['pedido/imprimircomanda?id='.$model->idpedido], ['class' => 'btn btn-lg btn-warning', 'id'=>'button-comanda']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar', 
                ['producto/productos?idpedido='.$model->idpedido], ['class' => 'btn btn-lg btn-success', 'id'=>'button-adicionar']) ?>
        
    </div>
    
    <div class='pull-right visible-xs'>
        <?= Html::a('<span class="glyphicon glyphicon-print" aria-hidden="true"></span>', 
                ['pedido/imprimircomanda?id='.$model->idpedido], ['class' => 'btn btn-lg btn-warning', 'id'=>'button-comanda']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', 
                ['producto/productos?idpedido='.$model->idpedido], ['class' => 'btn btn-lg btn-success', 'id'=>'button-adicionar']) ?>
    </div>
    
</div>

<style>
    .comentario{
        border: none !important; 
        font-size: 10px; 
        color: #585858; 
        margin: 0px !important; 
        padding-top: 0px !important;
        padding-bottom: 3px !important;
    }
</style>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h4>Adiciones pendientes</h4>

    <div class="panel panel-default">
      <table class="table">
          <tr>   
            <th>Producto</th>
          </tr>
        <?php
            foreach($pendientes as $detalle){ 
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
              <td rowspan="2">
                  <?= Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', 
                          ['pedido/remove?id='.$detalle->iddetalle], 
                          ['class' => 'btn btn-danger',
                              'title'=>'Eliminar']) ?>
              </td>
          </tr>
          
          <tr>
              <td colspan="3" class="comentario">
                  <?php echo $detalle->comentario; ?>
              </td>
          </tr>
          
        <?php        
            }
        ?>
      </table>
    </div>
</div>



<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h4>Adiciones</h4>

    <div class="panel panel-default">
      <table class="table">
          <tr>   
            <th>Producto</th>
          </tr>
        <?php
            foreach($realizadas as $detalle){ 
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
      </table>
    </div>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="pull-right hidden-xs">
        <?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar', 
                ['mesa/cerrarmesa?id='.$model->idpedido], ['class' => 'showModalButton btn btn-lg btn-danger', 'id'=>'button-adicionar', 'title' => 'Cerrar '.$model->mesa->nombre]) ?>
    </div>
    
    <div class='pull-right visible-xs'>
        <?= Html::a('<span class="glyphicon glyphicon-off" aria-hidden="true"></span>', 
                ['mesa/cerrarmesa?id='.$model->idpedido], ['class' => 'showModalButton btn btn-lg btn-danger', 'id'=>'button-adicionar', 'title' => 'Cerrar '.$model->mesa->nombre]) ?>
    </div>
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