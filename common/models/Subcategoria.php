<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subcategoria".
 *
 * @property integer $idsubcategoria
 * @property string $nombre
 * @property integer $categoria_idcategoria
 *
 * @property Producto[] $productos
 * @property Categoria $categoria
 */
class Subcategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subcategoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'categoria_idcategoria'], 'required'],
            [['categoria_idcategoria'], 'integer'],
            [['nombre'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsubcategoria' => 'Idsubcategoria',
            'nombre' => 'Nombre',
            'categoria_idcategoria' => 'Categoria Idcategoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['subcategoria_idsubcategoria' => 'idsubcategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['idcategoria' => 'categoria_idcategoria']);
    }
}
