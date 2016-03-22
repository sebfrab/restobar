<?php

namespace common\models;

use Yii;
use common\models\Pedido;
/**
 * This is the model class for table "mesa".
 *
 * @property integer $idmesa
 * @property string $nombre
 * @property integer $ubicacion_idubicacion
 *
 * @property Ubicacion $ubicacion
 * @property Pedido[] $pedidos
 */
class Mesa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $estado;
    
    public static function tableName()
    {
        return 'mesa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'ubicacion_idubicacion'], 'required'],
            [['ubicacion_idubicacion'], 'integer'],
            [['nombre'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idmesa' => '#',
            'nombre' => 'Nombre',
            'estado' => 'Estado',
            'ubicacion_idubicacion' => 'Ubicacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacion()
    {
        return $this->hasOne(Ubicacion::className(), ['idubicacion' => 'ubicacion_idubicacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPedidos()
    {
        return $this->hasMany(Pedido::className(), ['mesa_idmesa' => 'idmesa']);
    }
    
    public function getEstado(){
        $max = Pedido::find()
                ->where(['mesa_idmesa'=>$this->idmesa])
                ->max('idpedido');
        
        $model = Pedido::findOne($max);

        if(is_null($model))
            return 0;
        else
            return $model->estado->idestado;
    }
    
    public function getPedidoAbierto(){
        $max = Pedido::find()
                ->where([
                    'mesa_idmesa'=>$this->idmesa,
                    'estado_idestado'=>1,
                        ])
                ->max('idpedido');
        $model = Pedido::findOne($max);
        
        if(is_null($model))
            return null;
        else
            return $model->idpedido;
    }
    
    public function getPersonasPedidoAbierto(){
        $max = Pedido::find()
                ->where([
                    'mesa_idmesa'=>$this->idmesa,
                    'estado_idestado'=>1,
                        ])
                ->max('idpedido');
        $model = Pedido::findOne($max);
        
        if(is_null($model))
            return null;
        else
            return $model->personas;
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if($this->pedidos !== array()){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}
