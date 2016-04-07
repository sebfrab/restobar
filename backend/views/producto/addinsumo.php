<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
//atributo cantidad
use kartik\touchspin\TouchSpin;
?>


<?php
$js = <<<JS
$('form#{$model->formName()}').on('beforeSubmit', function(e) {
    var form = $(this);
    var cantidad = $('#productoinsumo-cantidad').val();
    $.ajax({
      url: form.attr('action'),
      type: 'post',
      data: form.serialize(),
      success: function(response) {
        if(response == 'success'){
            toastr.success(cantidad +'  $insumo->nombre adicionado(a)', 'Excelente!!!' );
            $.pjax.reload({container: '#insumosGridview'});
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

<div class="producto-form">

    <?php $form = ActiveForm::begin([
            'id' => $model->formName(), 
        ]); ?>
    
    <?= 
        $form->field($model, 'cantidad')->widget(TouchSpin::className(),[
            'name' => 't4',
            'pluginOptions' => [
                'initval' => 0.1,
                'min' => 0.1,
                'step' => 0.1,
                'decimals' => 1,
                'buttonup_class' => 'btn btn-default', 
                'buttondown_class' => 'btn btn-default', 
                'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                'postfix' => $unidadMedida->abreviacion
            ],
        ])
        ?>
         
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'agregar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>