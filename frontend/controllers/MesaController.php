<?php

namespace frontend\controllers;

use Yii;
use common\models\Mesa;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Pedido;

/**
 * MesaController implements the CRUD actions for mesa model.
 */
class MesaController extends Controller
{
    
    protected function findModel($id)
    {
        if (($model = mesa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /*LISTA TODAS LAS MESAS DEL LOCAL*/
    public function actionIndex()
    {
        $model = Mesa::find()->all();
        
        return $this->render('index',[
            'model' => $model,
        ]);
    }
    
    public function actionAbrirmesa($id){
        $model = new Pedido();
        $model->mesa_idmesa = $id;
        $model->fecha = date("d-m-Y H:i:s");
        $model->mesero = Yii::$app->user->identity->id;
        $model->estado_idestado = 1;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['pedido/admin?id='.$model->idpedido]);
        } else {
            $model->personas = 1;
            return $this->renderajax('abrirmesa', [
                'model' => $model,
            ]);
        }
    }    
}
