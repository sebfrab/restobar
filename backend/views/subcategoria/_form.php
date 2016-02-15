<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Categoria;

/* @var $this yii\web\View */
/* @var $model app\models\Subcategoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subcategoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoria_idcategoria')->dropDownList(
            ArrayHelper::map(Categoria::find()->all(),'idcategoria','nombre'),
            ['prompt' => 'Selecciona Categoria']
            ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
