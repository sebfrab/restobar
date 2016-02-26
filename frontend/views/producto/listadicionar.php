

<?php
    foreach ($model as $producto){
?>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 thumb">
            <a class="thumbnail" href="#">
                <img class="img-responsive" src='<?php echo $producto->urlImagen(); ?>' alt="">
                <?php echo $producto->nombre; ?><br/><br/>
            </a>
        </div>

<?php }?>
