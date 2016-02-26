<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//atributo cantidad
use kartik\touchspin\TouchSpin;
?>


<?php
$js = <<<JS
$('form#{$model->formName()}').on('beforeSubmit', function(e) {
    var form = $(this);
    var cantidad = $('#detalle-cantidad').val();
    $.ajax({
      url: form.attr('action'),
      type: 'post',
      data: form.serialize(),
      success: function(response) {
        if(response == 'success'){
            toastr.success(cantidad +'  $producto->nombre adicionado(a)', 'Excelente!!!' );
            $('#modal').modal('hide');
        }else{
            alert("Error en adicionar producto");
        }
      }
    });
}).on('submit', function(e){
    e.preventDefault();
});
JS;
 
$this->registerJs($js);
?>

<div class="row">
    
    <div  class="col-lg-6 col-md-6 col-sm-6 col-xs-6 thumb" style="padding-left: 3px; padding-right: 3px;">
        <a title="<?php echo $producto->nombre; ?>" class="thumbnail showModalButton">
            <img class="img-responsive" src='<?php echo $producto->urlImagen(); ?>' alt="">
        </a>
    </div>
    

    <div class="detalle-form col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php $form = ActiveForm::begin([
            'id' => $model->formName(), 
        ]); ?>

        <?= 
            $form->field($model, 'cantidad')->widget(TouchSpin::className(),[
                'name' => 't4',
                'pluginOptions' => [
                    'min' => 1,
                    'max' => 20,
                    'buttonup_class' => 'btn btn-default', 
                    'buttondown_class' => 'btn btn-default', 
                    'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                    'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                ]
            ])
        ?>

        <?= $form->field($model, 'comentario')->textarea(['rows' => 4]) ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'agregar') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
 
        <?php ActiveForm::end(); ?>
    </div>    
</div>