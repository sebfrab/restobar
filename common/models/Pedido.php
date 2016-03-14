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
 * @property Detalle[] $detallesRealizado
 * @property Detalle[] $detallesPendiente
 * @property Estado $estado
 * @property Mesa $mesa
 * @property User $mesero0
 * @property integer $totalPedido
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
    
    public function getDetallesRealizado()
    {
        return $this->hasMany(Detalle::className(), ['pedido_idpedido' => 'idpedido'])->andOnCondition(['>','comanda',0])->andOnCondition(['estado_idestado'=>1]);
    }
    
    public function getDetallesPendiente()
    {
        return $this->hasMany(Detalle::className(), ['pedido_idpedido' => 'idpedido'])->andOnCondition(['comanda' => 0]);
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
    
    public function imprimirComanda(){
        $max = Detalle::find()
                ->select('comanda')
                ->where([
                    'pedido_idpedido'=>$this->idpedido,
                        ])
                ->max('comanda');
        $comanda = $max + 1;
        foreach($this->detallesPendiente as $detalle){
            $detalle->comanda = $comanda;
            $detalle->save();
        }
    }
    
    public function getTotalpedido(){
        $total = 0;
        foreach($this->detallesRealizado as $detalle){
            $total += $detalle->getTotal();
        }
        return $total;
    }
}
