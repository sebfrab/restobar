<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "stock".
 *
 * @property integer $idstock
 * @property double $stock
 * @property integer $unidad_medida_idunidad_medida
 * @property integer $producto_idproducto
 * @property integer $insumo_idinsumo
 *
 * @property Insumo $insumo
 * @property Producto $producto
 * @property UnidadMedida $unidadMedida
 */
class Stock extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stock'], 'number'],
            [['unidad_medida_idunidad_medida', 'stock'], 'required'],
            [['unidad_medida_idunidad_medida', 'producto_idproducto', 'insumo_idinsumo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idstock' => 'Idstock',
            'stock' => 'Stock',
            'unidad_medida_idunidad_medida' => 'Unidad Medida',
            'producto_idproducto' => 'Producto',
            'insumo_idinsumo' => 'Insumo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInsumo()
    {
        return $this->hasOne(Insumo::className(), ['idinsumo' => 'idproducto_insumo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['idproducto' => 'idproducto_insumo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadMedida()
    {
        return $this->hasOne(UnidadMedida::className(), ['idunidad_medida' => 'unidad_medida_idunidad_medida']);
    }
}
