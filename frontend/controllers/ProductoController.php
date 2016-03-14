<?php

namespace frontend\controllers;

use Yii;
use common\models\Detalle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;
use common\models\Producto;
use common\models\Categoria;
use common\models\Subcategoria;
use \common\models\Pedido;

/**
 * PedidoController implements the CRUD actions for Pedido model.
 */
class ProductoController extends Controller
{
    
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select(['idproducto as id', 'CONCAT(idproducto," - ", nombre) AS text'])
                ->from('producto')
                ->where(['like', 'nombre', $q])
                ->orWhere(['like', 'idproducto', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Producto::find($id)->nombre];
        }
        return $out;
    }
    
    public function actionProductos(){
        
        $request = Yii::$app->request;
        if(!is_null($request->get('idpedido'))){
            $session = Yii::$app->session;
            $session->set('idpedido', $request->get('idpedido'));
            $pedido = Pedido::findOne($request->get('idpedido'));
            $model = Categoria::find()->all();
        
            return $this->render('productos', [
                'model' => $model,
                'pedido' => $pedido,
            ]);
            
        }else{
            return $this->redirect(['site/index']);
        } 
    }
    
    public function actionListproductos(){
        
        $request = Yii::$app->request;

        if(!is_null($request->get('idcategoria'))){
            $idcategoria = $request->get('idcategoria');
            $model = Subcategoria::find()
                    ->where(['categoria_idcategoria'=>$idcategoria])
                    ->all();
            return $this->renderAjax('listproductos', [
                'model' => $model,
            ]);
        }else{
            return null;
        } 
    }
    
    public function actionAdicionar($id){
        $producto = $this->findModel($id);
        
        $model = new Detalle;
        $model->cantidad = 1;

        if ($model->load(Yii::$app->request->post() )) {

            $session = Yii::$app->session;
            $model->producto_idproducto = $producto->idproducto;
            $model->pedido_idpedido = $session->get('idpedido');
            $model->precio = $producto->precioVenta();
            $model->comanda = 0;
            $model->estado_idestado = 1;
            
            if($model->save()){
                return 'success';
            } else {
               return 'false';
            }
             
        }else{
            return $this->renderAjax('adicionar', [
               'model' => $model,
               'producto' => $producto,
           ]);
        }
    }
    
}
