<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property integer $idproducto
 * @property string $nombre
 * @property integer $precio
 * @property string $descripcion
 * @property integer $subcategoria_idsubcategoria
 *
 * @property Detalle[] $detalles
 * @property Subcategoria $subcategoria
 */
class Producto extends \yii\db\ActiveRecord
{
    public $file;
    
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'precio', 'subcategoria_idsubcategoria'], 'required'],
            [['precio', 'subcategoria_idsubcategoria'], 'integer'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idproducto' => 'Idproducto',
            'nombre' => 'Nombre',
            'precio' => 'Precio',
            'descripcion' => 'Descripcion',
            'subcategoria_idsubcategoria' => 'Subcategoria Idsubcategoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalles()
    {
        return $this->hasMany(Detalle::className(), ['producto_idproducto' => 'idproducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoria()
    {
        return $this->hasOne(Subcategoria::className(), ['idsubcategoria' => 'subcategoria_idsubcategoria']);
    }
    
    public function urlImagen(){
        if(file_exists(Yii::$app->homeUrl.'images/productos/'.$this->idproducto.'.jpg')){
            return Yii::$app->homeUrl.'images/productos/'.$this->idproducto.'.jpg';
        }else{
            return Yii::$app->homeUrl.'images/productos/0.png';
        }
    }
}
