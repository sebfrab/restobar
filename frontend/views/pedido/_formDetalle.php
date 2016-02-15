<?php
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;
use kartik\select2\Select2;
use yii\web\JsExpression;
 
/* @var $this yii\web\View */
/* @var $model app\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>
 
<?php
 
$this->registerJs(
   '$("document").ready(function(){ 
        $("#new_detalle").on("pjax:end", function() {
            $.pjax.reload({container:"#detalles"});
        });
    });'
);
?>
 
<div class="detalle-form">
 
<?php yii\widgets\Pjax::begin(['id' => 'new_detalle']) ?>
<?php $form = ActiveForm::begin(['options' => ['data-pjax' => true ]]); ?>
 
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
    
    <?php 
    $url = \yii\helpers\Url::to(['producto/list']);
    $productoDesc = empty($model->producto_idproducto) ? '' : Producto::findOne($model->producto_idproducto)->nombre;
    

    echo $form->field($model, 'producto_idproducto')->widget(Select2::classname(), [
        'initValueText' => $productoDesc, // set the initial display text
        'options' => ['placeholder' => 'Buscar producto'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(producto) { return producto.text; }'),
            'templateSelection' => new JsExpression('function (producto) { return producto.text; }'),
        ],
    ]);
    ?>
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'agregar') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
 
<?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>
</div>