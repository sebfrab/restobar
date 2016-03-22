<?php

namespace backend\controllers;

use Yii;
use common\models\Promocion;
use common\models\search\PromocionSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\search\ProductoSearch;
use common\models\Producto;
use common\models\PromocionProducto;

/**
 * PromocionController implements the CRUD actions for Promocion model.
 */
class PromocionController extends Controller
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
        ];
    }

    /**
     * Lists all Promocion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PromocionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Promocion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
            
        return $this->render('view', [
            'promocion' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Promocion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Promocion();
        $model->estado_idestado = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpromocion]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Promocion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idpromocion]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Promocion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            Yii::$app->getSession()->setFlash('success', 'Producto eliminado');
        }else{
            Yii::$app->getSession()->setFlash('error', 'Producto no puedo ser eliminado');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Promocion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Promocion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Promocion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAddproduct($id){
        
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if(!is_null($request->get('idproducto'))){
            $promocionProducto = new PromocionProducto();
            $promocionProducto->promocion_idpromocion = $model->idpromocion;
            $promocionProducto->producto_idproducto = $request->get('idproducto');
            
            if($promocionProducto->save()){
                return 'success';
            }
        }else{
            return 'false';
        }
    }
    
     public function actionRemoveproduct($id){
         $model = $this->findModel($id);

         $request = Yii::$app->request;
         if(!is_null($request->get('idproducto'))){

            $promocionProducto = $model->findProducto($request->get('idproducto'));
            
            if($promocionProducto->delete()){
                return 'success';
            }else{
                return 'false';
            }
         }else{
            return 'false';
         }
     }
}
