<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>



<style>
    .rombo {
     width: 30px; 
     height: 30px; 
     border: 3px solid #555; 
     background: #428bca;
     -webkit-transform: rotate(45deg);
     -moz-transform: rotate(45deg);
     -ms-transform: rotate(45deg);
     -o-transform: rotate(45deg);
     transform: rotate(45deg);
}
</style>

<div class="list-group">
    <?php
    foreach ($model->mesas as $mesa){
        if($mesa->getEstado() == 0 || $mesa->getEstado() == 2){
            echo Html::button($mesa->nombre, 
                        ['value' => Url::to(['mesa/abrirmesa', 'id' => $mesa->idmesa]), 
                        'title' => "Abrir ".$mesa->nombre, 
                        'class' => 'showModalButton list-group-item list-group-item-success']); 
        }else{
            echo Html::a($mesa->nombre, ['pedido/admin', 'id' => $mesa->getPedidoAbierto()], ['class' => 'list-group-item list-group-item-danger']);
        }
        
        
        
    ?>
    <?php }?>
</div>