<style>
    .mesa{
        height: 110px;
        background-color: #000;
        border: 4px solid !important;
        margin-left: 5px;
        margin-right: 5px;
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        margin-top: 30px;
    }
    
    .disponible{
        background-color: #bce690 !important;
        border-color: #55aa55 !important;
    }
    
    .disponible:hover{
        background-color: #afd785 !important;
        color: #fff !important;
    }
    
    .ocupado{
        background-color: #f8a068 !important;
        border-color: #cc3333 !important;
    }
    
    .ocupado:hover{
        background-color: #f09358 !important;
        color: #fff !important;
    }
    
    .mesa{
        font-size: 38px !important;
        font-weight: bold !important;
        color: #fff !important;
    }
    
</style>

<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="container-fluid">
            <div class="row">
                <?php 
                foreach ($model as $mesa){
                    
                    if($mesa->getEstado() == 0 || $mesa->getEstado() == 2){
                        $class='showModalButton disponible ';
                        $url = Url::to(['mesa/abrirmesa', 'id' => $mesa->idmesa]);
                        $title = 'Abrir '.$mesa->nombre;
                        
                        echo Html::button($mesa->idmesa, 
                        ['value' => $url, 
                        'title' => $title, 
                        'class' => 'btn mesa '.$class.'  col-lg-1 col-md-2 col-sm-2 col-xs-3']); 
                    }else{
                        $class=' ocupado ';
                        
                        echo Html::a($mesa->idmesa, ['pedido/admin', 'id' => $mesa->getPedidoAbierto()], ['class' => 'btn mesa '.$class.'  col-lg-1 col-md-2 col-sm-2 col-xs-3']);
                    }
                }
                ?>
            </div>
            
            
            <?php
                Modal::begin([
                    'header' => '<span id="modalHeaderTitle"></span>',
                    'id' => 'modal',
                    'size' => 'modal-lg',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
                ]);
                echo "<div id='modalContent'></div>";
                Modal::end();
            ?> 
            
                       
        </div>
    </div>
</div>