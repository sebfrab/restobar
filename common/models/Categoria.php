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
            'idcategoria' => '#',
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
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if($this->subcategorias !== array()){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}
