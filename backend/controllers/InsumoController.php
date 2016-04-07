<?php

namespace backend\controllers;

use Yii;
use common\models\Insumo;
use common\models\search\InsumoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Stock;

/**
 * InsumoController implements the CRUD actions for Insumo model.
 */
class InsumoController extends Controller
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
     * Lists all Insumo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InsumoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Insumo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Insumo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Insumo();
        $stock = new Stock();
        
        if($model->load(Yii::$app->request->post()) && $stock->load(Yii::$app->request->post()))
        {
            if($model->validate() && $stock->validate())
            {
                if($model->save()){
                    $stock->insumo_idinsumo = $model->idinsumo;
                    $stock->save();
                    return $this->redirect(['view', 'id' => $model->idinsumo]);
                }
            }
        }
        
        return $this->render('create', [
            'model' => $model,
            'stock' => $stock,
        ]);        
    }

    /**
     * Updates an existing Insumo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $stock = $model->stock;

        if($model->load(Yii::$app->request->post()) && $stock->load(Yii::$app->request->post()))
        {
            if($model->validate() && $stock->validate())
            {
                if($model->save()){
                    $stock->save();
                    return $this->redirect(['view', 'id' => $model->idinsumo]);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'stock' => $stock,
        ]);  
        
    }

    /**
     * Deletes an existing Insumo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Insumo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Insumo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Insumo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
