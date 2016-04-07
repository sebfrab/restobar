<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producto_insumo".
 *
 * @property integer $idproducto_insumo
 * @property integer $insumo_idinsumo
 * @property integer $producto_idproducto
 * @property double $cantidad
 *
 * @property Insumo $insumo
 * @property Producto $producto
 */
class ProductoInsumo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_insumo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['insumo_idinsumo', 'producto_idproducto', 'cantidad'], 'required'],
            [['insumo_idinsumo', 'producto_idproducto'], 'integer'],
            [['cantidad'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idproducto_insumo' => 'Idproducto Insumo',
            'insumo_idinsumo' => 'Insumo Idinsumo',
            'producto_idproducto' => 'Producto Idproducto',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumo()
    {
        return $this->hasOne(Insumo::className(), ['idinsumo' => 'insumo_idinsumo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['idproducto' => 'producto_idproducto']);
    }
}
