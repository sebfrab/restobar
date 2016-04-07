<?php

namespace backend\controllers;

use Yii;
use common\modules\auth\AuthItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * RbacController implements the CRUD actions for AuthItem model.
 */
class RbacController extends Controller
{

    

    public function actionCreate_permission()
    {
            $auth = Yii::$app->authManager;

            /******************************************************************/
            // mesa/index
            $mesa_index = $auth->createPermission('app-frontend/mesa/index');
            $mesa_index->description = 'muestra todas las mesas del local con su estado';
            $auth->add($mesa_index);
            
            // mesa/abrirmesa
            $mesa_abrir = $auth->createPermission('app-frontend/mesa/abrirmesa');
            $mesa_abrir->description = 'abrir la mesa para tomar pedido';
            $auth->add($mesa_abrir);
            
            // mesa/cerrarmesa
            $mesa_cerrar = $auth->createPermission('app-frontend/mesa/cerrarmesa');
            $mesa_cerrar->description = 'cierra la mesa para cancelar pedido';
            $auth->add($mesa_cerrar);
            
            
            /******************************************************************/
            // producto/productos
            $producto_productos = $auth->createPermission('app-frontend/producto/productos');
            $producto_productos->description = 'para la seleccion de productos a adicionar';
            $auth->add($producto_productos);
            
            // producto/listproductos
            $producto_listproductos = $auth->createPermission('app-frontend/producto/listproductos');
            $producto_listproductos->description = 'devuelve un Json con el listado de productos segun categoria';
            $auth->add($producto_listproductos);
            
            // producto/adicionar
            $producto_adicionar = $auth->createPermission('app-frontend/producto/adicionar');
            $producto_adicionar->description = 'formulario para agregar productos al pedido';
            $auth->add($producto_adicionar);
            
            
            
            /******************************************************************/
            // pedido/admin
            $pedido_admin = $auth->createPermission('app-frontend/pedido/admin');
            $pedido_admin->description = 'administracion de un pedido en especifico';
            $auth->add($pedido_admin);
            
            // pedido/remove
            $pedido_remove = $auth->createPermission('app-frontend/pedido/remove');
            $pedido_remove->description = 'eliminar un producto solicitado (antes de enviar la comanda)';
            $auth->add($pedido_remove);
            
            // pedido/imprimircomanda
            $pedido_imprimircomanda = $auth->createPermission('app-frontend/pedido/imprimircomanda');
            $pedido_imprimircomanda->description = 'imprime comanda de los productos aun en espera';
            $auth->add($pedido_imprimircomanda);
            
            // pedido/anularproductocomanda
            $pedido_anularproductocomanda = $auth->createPermission('app-frontend/pedido/anularproductocomanda');
            $pedido_anularproductocomanda->description = 'imprime comanda de los productos aun en espera';
            $auth->add($pedido_anularproductocomanda);
            
            
            $camarero = $auth->createRole('camarero');
            $auth->add($camarero);
            $auth->addChild($camarero, $mesa_index);
            $auth->addChild($camarero, $mesa_abrir);
            $auth->addChild($camarero, $mesa_cerrar);
            $auth->addChild($camarero, $producto_productos);
            $auth->addChild($camarero, $producto_listproductos);
            $auth->addChild($camarero, $producto_adicionar);
            $auth->addChild($camarero, $pedido_admin);
            $auth->addChild($camarero, $pedido_remove);
            $auth->addChild($camarero, $pedido_imprimircomanda);
            
            
            $admin = $auth->createRole('admin');
            $auth->add($admin);
            $auth->addChild($admin, $camarero);  
            $auth->addChild($admin, $pedido_anularproductocomanda);  
            
            $auth->assign($camarero, 1);
    }


    public function actionCreate_role()
    {
        $auth = Yii::$app->authManager;
        // Author -> index/create/view
        // Admin -> {Author} and update/delete -> index/create/view/update/delete

        $index = $auth->createPermission('rbac/index');
        $create = $auth->createPermission('rbac/create');
        $view = $auth->createPermission('rbac/view');

        $update = $auth->createPermission('rbac/update');
        $delete = $auth->createPermission('rbac/delete');

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('camarero');
        $auth->add($author);
        $auth->addChild($author, $index);
        $auth->addChild($author, $create);
        $auth->addChild($author, $view);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
    }

    public function actionAssigment()
    {
        $auth = Yii::$app->authManager;

        $author = $auth->createRole('author');
        $admin = $auth->createRole('admin');

        $auth->assign($admin, 1);
    }
    
    
    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
