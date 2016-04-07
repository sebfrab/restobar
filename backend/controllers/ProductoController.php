<?php

namespace backend\controllers;

use Yii;
use common\models\Producto;
use common\models\Stock;
use common\models\search\ProductoSearch;
use common\models\search\InsumoSearch;
use \common\models\ProductoInsumo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends Controller
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
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Producto model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        
        $searchModel = new InsumoSearch();
        $dataProvider = $searchModel->search_by_id(Yii::$app->request->queryParams, $id);
        
        return $this->render('view', [
            'producto' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Producto();
        $stock = new Stock();
        $stock->stock = 0;

        if($model->load(Yii::$app->request->post()) && $stock->load(Yii::$app->request->post()))
        {
            $stock->unidad_medida_idunidad_medida = 0;
            $stock->producto_idproducto = null;
            $stock->insumo_idinsumo = null;
            
            if($model->validate() && $stock->validate())
            {
                if($model->save()){
                    if($model->file = UploadedFile::getInstance($model, 'file')){
                        $model->file->saveAs('../../frontend/web/images/productos/'.$model->idproducto.'.'.$model->file->extension);
                    }
                    $stock->producto_idproducto = $model->idproducto;
                    $stock->save();
                    return $this->redirect(['view', 'id' => $model->idproducto]);
                }
            }
        }
        
        return $this->render('create', [
                'model' => $model,
                'stock' => $stock,
            ]);

    }

    /**
     * Updates an existing Producto model.
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
                    if($model->file = UploadedFile::getInstance($model, 'file')){
                        $model->file->saveAs('../../frontend/web/images/productos/'.$model->idproducto.'.'.$model->file->extension);
                    }
                    $stock->save();
                    return $this->redirect(['view', 'id' => $model->idproducto]);
                }
            }
        }
        
        return $this->render('update', [
            'model' => $model,
            'stock' => $stock,
        ]);
        
    }

    /**
     * Deletes an existing Producto model.
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
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelinsumo($id)
    {
        if (($model = \common\models\Insumo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAddinsumo($id){
        $producto = $this->findModel($id);
        $request = Yii::$app->request;
        if(!is_null($request->get('idinsumo'))){
            $insumo =  $this->findModelinsumo($request->get('idinsumo'));
            $model = new ProductoInsumo();
            $model->producto_idproducto = $producto->idproducto;
            $model->insumo_idinsumo = $insumo->idinsumo;
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    return 'success';
                } else {
                   return 'false';
                }
            }else{         
                $unidadMedida = $insumo->stock->unidadMedida;

                return $this->renderajax('addinsumo', [
                    'model' => $model,
                    'unidadMedida'  => $unidadMedida,
                    'insumo' => $insumo
                ]);
            }
        }
    }
    
    
    //FALTA CORREGIR
    public function actionRemoveinsumo($id){
        $producto = $this->findModel($id);

        $request = Yii::$app->request;
        if(!is_null($request->get('idinsumo'))){
            $producto_insumo = ProductoInsumo::find()->where([
                'producto_idproducto' => $producto->idproducto,
                'insumo_idinsumo' => $request->get('idinsumo')
            ])->one();
            
            if(is_null($producto_insumo))
                return 'false';
            
            if($producto_insumo->delete()){
                return 'success';
            }else{
                return 'false';
            }
         }else{
            return 'false';
         }
     }
}
