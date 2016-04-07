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
    
    public function getInProducto($idproducto){
        $model = ProductoInsumo::find()
                    ->where([
                        'producto_idproducto' => $idproducto,
                        'insumo_idinsumo' => $this->idinsumo
                    ])->limit(1)->all();
        return $model;
    }
    
    public static function getCantidadInsumoProducto($idinsumo, $idproducto){
        $model = ProductoInsumo::find()->where([
            'insumo_idinsumo' => $idinsumo,
            'producto_idproducto' => $idproducto
        ])->one();
        
        if(is_null($model)){
            return 0;
        }else{
            return $model->cantidad;
        }
    }
    
}