<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unidad_medida".
 *
 * @property integer $idunidad_medida
 * @property string $nombre
 * @property string $abreviacion
 *
 * @property Stock[] $stocks
 */
class UnidadMedida extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unidad_medida';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'abreviacion'], 'required'],
            [['nombre'], 'string', 'max' => 45],
            [['abreviacion'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idunidad_medida' => 'Idunidad Medida',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['unidad_medida_idunidad_medida' => 'idunidad_medida']);
    }
}
