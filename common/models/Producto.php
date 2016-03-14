<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property integer $idproducto
 * @property string $nombre
 * @property integer $precio
 * @property integer $precio_descuento
 * @property string $descripcion
 * @property integer $subcategoria_idsubcategoria
 *
 * @property Detalle[] $detalles
 * @property Subcategoria $subcategoria
  * @property PromocionProducto[] $promocionProductos
 */
class Producto extends \yii\db\ActiveRecord
{
    public $file;
    
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'precio', 'subcategoria_idsubcategoria'], 'required'],
            [['precio', 'subcategoria_idsubcategoria', 'precio_descuento'], 'integer'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idproducto' => 'Idproducto',
            'nombre' => 'Nombre',
            'precio' => 'Precio',
            'descripcion' => 'Descripcion',
            'subcategoria_idsubcategoria' => 'Subcategoria Idsubcategoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalles()
    {
        return $this->hasMany(Detalle::className(), ['producto_idproducto' => 'idproducto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategoria()
    {
        return $this->hasOne(Subcategoria::className(), ['idsubcategoria' => 'subcategoria_idsubcategoria']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromocionProductos()
    {
        return $this->hasMany(PromocionProducto::className(), ['producto_idproducto' => 'idproducto']);
    }
    
    public function urlImagen(){
        if(file_exists('../../frontend/web/images/productos/'.$this->idproducto.'.jpg')){
            return Yii::$app->homeUrl.'images/productos/'.$this->idproducto.'.jpg';
        }else{
            return Yii::$app->homeUrl.'images/productos/0.jpg';
        }
    }
    
    public function precioVenta(){
        $fechaactual = getdate();
        
        $year=date('Y');
        $month=date('m');
        $day=date('d');
        $dias=array("domingo","lunes","martes","miercoles" ,"jueves","viernes","sabado");
        $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
        $diaSemana = $dias[$diaSemana];
        
        $promociones = Promocion::find()->joinWith('promocionProductos')->
                where([
                    'promocion_producto.producto_idproducto' => $this->idproducto,
                    'estado_idestado' => 1,
                    $diaSemana => 1,
                ])
                ->andWhere(['<=','hora_inicio', date('H:i:s')])
                ->andWhere(['>=','hora_fin', date('H:i:s')])
                ->orderBy('idpromocion')
                ->limit(1)
                ->all();
        $promocion = null;
        foreach ($promociones as $pro){
            $promocion = $pro;
        }
        
        $descuento = 0;
        if(!is_null($promocion)){
            $descuento = $promocion->porcentaje_descuento;
        }
        
        /*AJUSTAR REGLA, LO DE PRECIO_DESCUENTO ESTÁ MALO*/
        if($descuento>0){
            $descuento_porcentaje = $promocion->porcentaje_descuento/100;
            $descuento_monto = (int)($this->precio * $descuento_porcentaje);
            return ($this->precio-$descuento_monto);
        }else if($this->precio_descuento>0){
            return $this->precio_descuento;
        }else{
            return $this->precio;
        }
    }
}
