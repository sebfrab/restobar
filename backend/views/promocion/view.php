<?php
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<?php
$url = Url::to(['/promocion/addproduct', 'id' => $promocion->idpromocion]);
$script = <<< JS
    
$('.eliminar').click(function(e) {
    e.preventDefault();

    alert($(this).val());
        
    return false;
    var idproducto = $(this).val()
    $.ajax({
        url: $(this).attr('href'),
        data: {idproducto: idproducto},
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
$this->registerJs($script);
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'precio',
            'subcategoria.nombre',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        
                        $session = Yii::$app->session;
                        
                        if( $model->getInPromocion($session->get('idpromocion')) == null){
                            $url = Url::to(['promocion/addproduct','idproducto'=>$model->idproducto]);
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>',$url , [
                                'title' => Yii::t('app', 'agregar a promoción'),
                                'class'=>'btn btn-success btn-xs',   
                                'data-method' => 'post'
                            ]);
                        }else{
                            $url = Url::to(['promocion/removeproduct','idproducto'=>$model->idproducto]);
                            return Html::a('<span class="glyphicon glyphicon-remove"></span>',$url , [
                                'title' => Yii::t('app', 'quitar de promoción'),
                                'class'=>'btn btn-danger btn-xs eliminar',   
                                'data-method' => 'post'
                            ]);
                        }
                    },
                ],
            ],
        ],
    ]); ?>