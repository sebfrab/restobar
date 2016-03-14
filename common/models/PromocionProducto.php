<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promocion_producto".
 *
 * @property integer $idpromocion_producto
 * @property integer $promocion_idpromocion
 * @property integer $producto_idproducto
 *
 * @property Producto $productoIdproducto
 * @property Promocion $promocionIdpromocion
 */
class PromocionProducto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promocion_producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['promocion_idpromocion', 'producto_idproducto'], 'required'],
            [['promocion_idpromocion', 'producto_idproducto'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpromocion_producto' => 'Idpromocion Producto',
            'promocion_idpromocion' => 'Promocion Idpromocion',
            'producto_idproducto' => 'Producto Idproducto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoIdproducto()
    {
        return $this->hasOne(Producto::className(), ['idproducto' => 'producto_idproducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromocionIdpromocion()
    {
        return $this->hasOne(Promocion::className(), ['idpromocion' => 'promocion_idpromocion']);
    }
}
