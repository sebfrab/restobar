<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Subcategoria;
use common\models\TipoProducto;

?>



<?php
/*dependiendo del tipo de producto muestra o no el stock del producto*/
$js = <<<JS
    var value = $('#producto-tipo_producto_idtipo_producto').val();
    if(value == 0){
        $('#stock-view').show();
    }else{
        $('#stock-view').hide();
    }
        
    $('#producto-tipo_producto_idtipo_producto').change(function(){
        var value = $(this).val();
        if(value == 0){
            $('#stock-view').show();
        }else{
            $('#stock-view').hide();
            $('#stock-stock').val(0);
        }
    });
JS;
 
$this->registerJs($js);
?>


<div class="producto-form">

    	<?php $form = ActiveForm::begin([
            'method' => 'post',
            'enableClientValidation' => true,
            'options' => ['enctype' => 'multipart/form-data'],
        ]);
        ?>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    </div>
        
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?= $form->field($model, 'precio', [
                            'addon' => ['prepend' => ['content'=>'$']]
            ])->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?= $form->field($model, 'precio_descuento', [
                            'addon' => ['prepend' => ['content'=>'$']]
            ])->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'subcategoria_idsubcategoria')->dropDownList(
            ArrayHelper::map(Subcategoria::find()->all(), 'idsubcategoria', 'nombre'),
            ['prompt' => 'Selecciona Subcategoria']
            ) ?>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'tipo_producto_idtipo_producto')->dropDownList(
            ArrayHelper::map(TipoProducto::find()->all(), 'idtipo_producto', 'nombre')
            ) ?>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'file')->fileInput()   ?>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div id="stock-view">
        <?= $form->field($stock, 'stock')->textInput(['maxlength' => true]) ?>
        </div>
    </div>  
    
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group col-lg-12 col-md-12 col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
