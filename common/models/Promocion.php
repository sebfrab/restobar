<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "promocion".
 *
 * @property integer $idpromocion
 * @property string $nombre
 * @property string $porcentaje_descuento
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property integer $lunes
 * @property integer $martes
 * @property integer $miercoles
 * @property integer $jueves
 * @property integer $viernes
 * @property integer $sabado
 * @property integer $domingo
 * @property integer $estado_idestado
 *
 * @property Estado $estado
 * @property PromocionProducto[] $promocionProductos
  * @property Detalle[] $detalles
 */
class Promocion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promocion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'hora_inicio', 'hora_fin', 'estado_idestado'], 'required'],
            [['porcentaje_descuento'], 'number'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'estado_idestado'], 'integer'],
            [['nombre'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpromocion' => 'Idpromocion',
            'nombre' => 'Nombre',
            'porcentaje_descuento' => 'Porcentaje Descuento',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miercoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sabado',
            'domingo' => 'Domingo',
            'estado_idestado' => 'Estado',
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
    public function getPromocionProductos()
    {
        return $this->hasMany(PromocionProducto::className(), ['promocion_idpromocion' => 'idpromocion']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalles()
    {
        return $this->hasMany(Detalle::className(), ['promocion_idpromocion' => 'idpromocion']);
    }
    
    
    public function findProducto($id){
        $model = PromocionProducto::find()
                    ->where([
                        'producto_idproducto' => $id,
                        'promocion_idpromocion' => $this->idpromocion
                    ])->one();

        return $model;
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if($this->promocionProductos !== array()){
                return false;
            }
            if($this->detalles !== array()){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}
