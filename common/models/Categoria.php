<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property integer $idcategoria
 * @property string $nombre
 *
 * @property Subcategoria[] $subcategorias
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcategoria' => 'Idcategoria',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategorias()
    {
        return $this->hasMany(Subcategoria::className(), ['categoria_idcategoria' => 'idcategoria']);
    }
}
