<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property integer $idproducto
 * @property string $nombre
 * @property integer $precio
 * @property string $descripcion
 * @property integer $subcategoria_idsubcategoria
 * @property integer $precio_descuento
 * @property integer $tipo_producto_idtipo_producto
 *
 * @property Detalle[] $detalles
 * @property Subcategoria $subcategoria
 * @property PromocionProducto[] $promocionProductos
 * @property Stock $stock
 * @property TipoProducto $tipoProducto
 * @property ProductoInsumo[] $productoInsumos
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
            [['nombre', 'precio', 'subcategoria_idsubcategoria', 'precio_descuento', 'tipo_producto_idtipo_producto'], 'required'],
            [['precio', 'subcategoria_idsubcategoria', 'precio_descuento', 'tipo_producto_idtipo_producto'], 'integer'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 45],
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
            'subcategoria_idsubcategoria' => 'Subcategoria',
            'precio_descuento' => 'Precio Descuento',
            'tipo_producto_idtipo_producto' => 'Tipo',
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['producto_idproducto' => 'idproducto']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoProducto()
    {
        return $this->hasOne(TipoProducto::className(), ['idtipo_producto' => 'tipo_producto_idtipo_producto']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoInsumos()
    {
        return $this->hasMany(ProductoInsumo::className(), ['producto_idproducto' => 'idproducto']);
    }
    
    
    
    public function urlImagen(){
        if(file_exists('../../frontend/web/images/productos/'.$this->idproducto.'.jpg')){
            return Yii::$app->homeUrl.'images/productos/'.$this->idproducto.'.jpg';
        }else{
            return Yii::$app->homeUrl.'images/productos/0.jpg';
        }
    }
    
    public function precioVenta(){
        $descuento = 0;
        $promocion = $this->getPromocion();
        if(!is_null($promocion)){
            $descuento = $promocion->porcentaje_descuento;
        }
        
        if($descuento>0){
            $descuento_porcentaje = $promocion->porcentaje_descuento/100;
            $descuento_monto = (int)($this->precio * $descuento_porcentaje);
            return ($this->precio-$descuento_monto);
        }else if(!is_null($promocion) && $this->precio_descuento>0){
            return $this->precio_descuento;
        }else{
            return $this->precio;
        }
    }
    
    public function getPromocion(){
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
        
        return $promocion;
    }

    //para saber si el producto está dentro de la promoción entregada
    public function getInPromocion($idpromocion){
        $model = PromocionProducto::find()
                    ->where([
                        'producto_idproducto' => $this->idproducto,
                        'promocion_idpromocion' => $idpromocion
                    ])->limit(1)->all();
        return $model;
    }
    
    /*rebaja el stock del producto, dependiendo si este es con ingredientes o no*/   
    public function rebajarStockPedido($cantidad){
        if($this->tipo_producto_idtipo_producto == 0){
            //los productos sin ingredientes se rebajan en unidades, por eso solo se rebaja la cantidad solicitada
            $this->stock->stock -= $cantidad;
            $this->stock->save();
        }else{
            foreach ($this->productoInsumos as $productoInsumo){
                //cantidad de productos pedidos * la cantidad de insumo utilizado
                $productoInsumo->insumo->stock->stock -= ($productoInsumo->cantidad * $cantidad);
                $productoInsumo->insumo->stock->save();
            }
        }
    }
    
    // valida que el producto no tenga ninguna relación, si la tiene la eliminación no se puede realizar
    // de caso contrario, se elimina el registro en la tabla stock y luego se procede a eliminar el producto
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if($this->detalles !== array() || $this->promocionProductos !== array() || $this->productoInsumos !== array()){
                return false;
            }else{
                $stock = $this->stock;
                $stock->delete();
            }
            return true;
        } else {
            return false;
        }
    }
}
