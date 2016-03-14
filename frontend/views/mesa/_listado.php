<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<style>
    .a_mesa{
        text-decoration: none;
    }
    
    .mesa{
        height: 110px;
        background-color: #fff;
        -webkit-box-shadow: 0px 2px 5px 0px rgba(83,82,83,0.75);
        -moz-box-shadow: 0px 2px 5px 0px rgba(83,82,83,0.75);
        box-shadow: 0px 2px 5px 0px rgba(83,82,83,0.75);
        color: #464646 !important;
    }
    
    .mesa p span{
        font-size: 28px; 
    }
    
    .disponible:hover{
        background-color: #1ed760;
        color: #fff !important;
    }
    .disponible:hover span{
        color: #fff !important;
    }
    .disponible p span{
        color: #1ed760;
    }
    
    
    .ocupado p span{
        color: #f06c76;
    }
    .ocupado:hover{
        background-color: #f06c76;
        color: #fff !important;
    }
    .ocupado:hover span{
        color: #fff !important;
    }
    
    
    .por_pagar p span{
        color: #58ACFA;
    }
    .por_pagar:hover{
        background-color: #58ACFA;
        color: #fff !important;
    }
    .por_pagar:hover span{
        color: #fff !important;
    }
</style>



    <?php
    foreach ($model->mesas as $mesa){
        $class = ' ocupado ';
        $a_class = '';
        $href= '';
        $icono = 'glyphicon-asterisk';
        $title = '';
        
        if($mesa->getEstado() == 0 || $mesa->getEstado() == 3){
            $a_class = 'showModalButton';
            $class = ' disponible ';
            $icono = 'glyphicon-ok';
            $title = "Abrir ".$mesa->nombre;
            $href= Url::to(['mesa/abrirmesa', 'id' => $mesa->idmesa]);
            $mensaje = 'disponible';
        }elseif($mesa->getEstado() == 2){
            $class = ' por_pagar ';
            $href= '#';
            $icono = 'glyphicon-asterisk';
            $mensaje = 'Por pagar';
        }else{
            $mensaje = 'personas '.$mesa->getPersonasPedidoAbierto();
            $href= Url::to(['pedido/admin', 'id' => $mesa->getPedidoAbierto()]);
        }
    ?>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4" style='margin-top: 10px;' >
            <a class='<?php echo $a_class; ?>' href="<?php echo $href; ?>" title='<?php echo $title; ?>'>
                <div class="mesa <?php echo $class; ?>">
                    <p style="text-align: center; 
                                position: absolute;
                                left: 50%;
                                top: 50%;
                                transform: translate(-50%, -50%);
                                -webkit-transform: translate(-50%, -50%);">
                        <b><?php echo $mesa->nombre; ?></b>
                        <br/>
                        <span class="glyphicon <?php echo $icono; ?>"></span>
                        <br/>
                        <span class="hidden-xs" style='font-size: 12px;'> <b><?php echo $mensaje; ?></b></span>
                    </p>
                </div>
            </a>
        </div>
    
    
    <?php  }?>