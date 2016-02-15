<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ubicacion".
 *
 * @property integer $idubicacion
 * @property string $nombre
 *
 * @property Mesa[] $mesas
 */
class Ubicacion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ubicacion';
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
            'idubicacion' => 'Idubicacion',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesas()
    {
        return $this->hasMany(Mesa::className(), ['ubicacion_idubicacion' => 'idubicacion']);
    }
}
