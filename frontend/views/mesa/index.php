
<?php 
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
?>

<?php
    $items=[];
    foreach($contenidos as $contenido){
        $items[] = [
            'label' => $contenido['nombre'], 
            'content' => $contenido['html'],
            'headerOptions' => ['style'=>'font-weight:bold'],];
    }
        
?>

<?php
echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
    'align' => TabsX::ALIGN_LEFT,
    'items' => $items
]);
?>


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