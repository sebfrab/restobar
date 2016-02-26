<?php
use yii\helpers\Url;    
?>


<div class="row">
    
<?php
foreach ($model as $subcategoria){
    
    if(count($subcategoria->productos)>0){
        echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'> ";
        echo "<h4>$subcategoria->nombre</h4>";
        foreach ($subcategoria->productos as $producto){
             $url = Url::to(['producto/adicionar', 'id' => $producto->idproducto]);
?>
            <div  class="col-lg-2 col-md-2 col-sm-2 col-xs-3 thumb" style="padding-left: 3px; padding-right: 3px;">
                <a title="<?= $producto->nombre . " | $" . number_format($producto->precio, 0, ",", "."); ?>" class="thumbnail showModalButton" href="<?php echo $url;  ?>">
                    <img class="img-responsive" src='<?php echo $producto->urlImagen(); ?>' alt="">
                </a>
            </div>
<?php   }
        echo "</div>";
    }
}
?>

</div>