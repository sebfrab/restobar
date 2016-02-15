<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Pedido */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pedido-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= 
        $form->field($model, 'personas')->widget(TouchSpin::className(),[
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

    <?= $form->field($model, 'comentario')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Abrir', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
