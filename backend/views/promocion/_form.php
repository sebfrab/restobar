<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\time\TimePicker;
use kartik\form\ActiveForm;

?>

<div class="promocion-form">

    <?php  $form = ActiveForm::begin([
        //'type' => ActiveForm::TYPE_INLINE
    ]); ?>


    <div class="col-lg-10 col-md-10 col-sm-8">
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-lg-2 col-md-2 col-sm-4">
        <?= $form->field($model, 'porcentaje_descuento', [
                            'addon' => ['append' => ['content'=>'%']]
            ])->textInput(['maxlength' => true]) ?>
    </div>    
    
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'hora_inicio')->widget(TimePicker::classname(), ['pluginOptions' => [
        'showSeconds' => true,
        'showMeridian' => false,
        'minuteStep' => 1,
    ]])  ?>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'hora_fin')->widget(TimePicker::classname(), ['pluginOptions' => [
        'showSeconds' => true,
        'showMeridian' => false,
        'minuteStep' => 1,
    ]])  ?>
    </div>

    
    <div class="col-lg-2 col-md-3 col-sm-3">
        <?= $form->field($model, 'lunes')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>
    
    <div class="col-lg-2 col-md-3 col-sm-3">
        <?= $form->field($model, 'martes')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-3">
        <?= $form->field($model, 'miercoles')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-3">
        <?= $form->field($model, 'jueves')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-3">
    <?= $form->field($model, 'viernes')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>

    <div class="col-lg-2 col-md-3 col-sm-3">
    <?= $form->field($model, 'sabado')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>

    <div class="col-lg-12 col-md-3 col-sm-3">
    <?= $form->field($model, 'domingo')->widget(CheckboxX::classname(), [
            'autoLabel'=>true,
            'pluginOptions' => [
                'threeState' => false,
            ],
        ])->label(false); ?>
    </div>


    <div class="form-group col-lg-12 col-md-12 col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? 'Ingresar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
