<?php

namespace frontend\controllers;

use Yii;
use common\models\Pedido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Detalle;
use common\models\Producto;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
{
    
    protected function findModel($id)
    {
        if (($model = Pedido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAdmin($id){
        $model = Pedido::findOne($id);

        $pendiente = null;
        if(isset($model->detallesPendiente)){
            $pendiente = $model->detallesPendiente;
        }
        
        $realizado = null;
        if(isset($model->detallesRealizado)){
            $realizado = $model->detallesRealizado;
        }
        
        return $this->render('admin', [
            'pendientes' => $pendiente,
            'realizadas' => $realizado,
            'model' => $model
        ]);
    }
    
    public function actionCerrar($id){
        $model = Pedido::findOne($id);
        $model->estado_idestado = 2;
        $model->save();
        $this->redirect(array('mesa/index'));
    }
    
    public function actionAdicionar($id){
        $pedido = Pedido::findOne($id);
        
        $model = new Detalle();
        $model->pedido_idpedido = $pedido->idpedido;
        
        if ($model->load(Yii::$app->request->post())) {   
            $producto = Producto::findOne($model->producto->idproducto);
            $model->precio = $producto->precio;
            $model->comanda = 0;
            $model->estado_idestado = 1;
           
            $model->save();
            return $this->redirect(['admin', 'id' => $pedido->idpedido]);
        }
        $model->cantidad = 1;
        return $this->renderAjax('_formDetalle', [
            'model' => $model,
        ]);
    }
    
    public function actionRemove($id){
        $model = Detalle::findOne($id);
        
        $pedido = $model->pedido;
        
        $model->delete();

        return $this->redirect(['admin', 'id' => $pedido->idpedido]);
    }
    
    public function actionImprimircomanda($id){
        $model = Pedido::findOne($id);
        $model->imprimirComanda();
        return $this->redirect(['admin', 'id' => $model->idpedido]);
    }
        
}
