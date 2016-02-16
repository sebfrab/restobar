<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "detalle".
 *
 * @property string $iddetalle
 * @property integer $cantidad
 * @property integer $precio
 * @property integer $pedido_idpedido
 * @property integer $producto_idproducto
 * @property integer $comanda
 * @property integer $estado_idestado
 *
 * @property Estado $estado
 * @property Pedido $pedido
 * @property Producto $producto
 */
class Detalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cantidad', 'precio', 'pedido_idpedido', 'producto_idproducto', 'comanda', 'estado_idestado'], 'integer'],
            [['precio', 'pedido_idpedido', 'producto_idproducto', 'estado_idestado'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iddetalle' => 'Iddetalle',
            'cantidad' => 'Cantidad',
            'precio' => 'Precio',
            'pedido_idpedido' => 'Pedido Idpedido',
            'producto_idproducto' => 'Producto Idproducto',
            'comanda' => 'Comanda',
            'estado_idestado' => 'Estado Idestado',
        ];
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
    public function getPedido()
    {
        return $this->hasOne(Pedido::className(), ['idpedido' => 'pedido_idpedido']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Producto::className(), ['idproducto' => 'producto_idproducto']);
    }
    
    public function getTotal(){
        return ($this->cantidad * $this->precio);
    }
}
