<?php

namespace frontend\controllers;

use Yii;
use common\models\Pedido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Query;

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
}
