<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\UnidadMedida;

/* @var $this yii\web\View */
/* @var $model common\models\Insumo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="insumo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($stock, 'stock')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($stock, 'unidad_medida_idunidad_medida')->dropDownList(
            ArrayHelper::map(UnidadMedida::find()->all(), 'idunidad_medida', 'nombre'),
            ['prompt' => 'Selecciona unidad de medida']
            ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
