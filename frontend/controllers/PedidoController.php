<?php

namespace frontend\controllers;

use Yii;
use common\models\Pedido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Detalle;
use common\models\Producto;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class PedidoController extends Controller
{
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                               $module = Yii::$app->controller->module->id;
                               $controller = Yii::$app->controller->id;
                               $action = Yii::$app->controller->action->id;
                               $route = "$module/$controller/$action";
                               //$route = "$controller/$action";
                               $post = Yii::$app->request->post();
                               if (\Yii::$app->user->can($route)) {
                                   return true;
                               }

                           },
                    ],
                ],
            ]
        ];        
    }
    
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
            $model->precio = $producto->precioVenta();
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
    
    public function actionAnularproductocomanda($id){
        $model = Detalle::findOne($id);
        
        $pedido = $model->pedido;
        
        $model->estado_idestado = 0;
        $model->save();

        return $this->redirect(['admin', 'id' => $pedido->idpedido]);
    }
}
