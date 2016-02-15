<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pedido".
 *
 * @property integer $idpedido
 * @property string $fecha
 * @property integer $personas
 * @property string $comentario
 * @property integer $mesa_idmesa
 * @property integer $mesero
 * @property integer $estado_idestado
 *
 * @property Detalle[] $detalles
 * @property Estado $estado
 * @property Mesa $mesa
 * @property User $mesero0
 */
class Pedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'mesa_idmesa', 'mesero', 'estado_idestado'], 'required'],
            [['fecha'], 'safe'],
            [['personas', 'mesa_idmesa', 'mesero', 'estado_idestado'], 'integer'],
            [['comentario'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpedido' => 'Idpedido',
            'fecha' => 'Fecha',
            'personas' => 'Personas',
            'comentario' => 'Comentario',
            'mesa_idmesa' => 'Mesa Idmesa',
            'mesero' => 'Mesero',
            'estado_idestado' => 'Estado Idestado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalles()
    {
        return $this->hasMany(Detalle::className(), ['pedido_idpedido' => 'idpedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['idestado' => 'estado_idestado']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesa()
    {
        return $this->hasOne(Mesa::className(), ['idmesa' => 'mesa_idmesa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMesero0()
    {
        return $this->hasOne(User::className(), ['id' => 'mesero']);
    }
}
