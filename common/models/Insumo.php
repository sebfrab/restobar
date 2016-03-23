<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "insumo".
 *
 * @property integer $idinsumo
 * @property string $nombre
 *
 * @property ProductoInsumo[] $productoInsumos
 * @property Stock $stock
 */
class Insumo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'insumo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idinsumo' => 'Idinsumo',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoInsumos()
    {
        return $this->hasMany(ProductoInsumo::className(), ['insumo_idinsumo' => 'idinsumo']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['insumo_idinsumo' => 'idinsumo']);
    }
}
