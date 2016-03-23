<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Subcategoria;
use common\models\TipoProducto;

/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    	<?php $form = ActiveForm::begin([
            'method' => 'post',
            'enableClientValidation' => true,
            'options' => ['enctype' => 'multipart/form-data'],
        ]);
        ?>


    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'precio')->textInput() ?>
    
    <?= $form->field($model, 'precio_descuento')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file')->fileInput()   ?>
    
    <?= $form->field($model, 'subcategoria_idsubcategoria')->dropDownList(
            ArrayHelper::map(Subcategoria::find()->all(), 'idsubcategoria', 'nombre'),
            ['prompt' => 'Selecciona Subcategoria']
            ) ?>
    
    <?= $form->field($model, 'tipo_producto_idtipo_producto')->dropDownList(
            ArrayHelper::map(TipoProducto::find()->all(), 'idtipo_producto', 'nombre'),
            ['prompt' => 'Selecciona tipo de producto']
            ) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
