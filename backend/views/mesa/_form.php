<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $model app\models\Mesa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mesa-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => true,]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubicacion_idubicacion')->dropDownList(
            ArrayHelper::map(Ubicacion::find()->all(), 'idubicacion', 'nombre'),
            ['prompt' => 'Selecciona ubicación']
            ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

