<?php

namespace app\modules\administracion\controllers;

use app\modules\administracion\models\AuthItem;
use Yii;
use app\modules\administracion\models\AuthItemChild;
use app\modules\administracion\models\AuthItemChildSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AuthItemchildController implements the CRUD actions for AuthItemChild model.
 */
class AuthitemchildController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItemChild models.
     * @return mixed
     */



    public function actionIndex()
    {
        $searchModel = new AuthItemChildSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $roles = AuthItem::findAll(['type'=>1]);
        $tree = [];
        foreach($roles as $rol){
            $permisos = AuthItemChild::findAll(['parent'=>$rol->name]);
            $tree [$rol->name] = [];

            foreach($permisos as $permiso){
              array_push($tree[$rol->name],$permiso);
            }
        }

        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tree'=>$tree,

        ]);
    }

    /**
     * Displays a single AuthItemChild model.
     * @param string $parent
     * @param string $child
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($parent, $child)
    {
        return $this->render('view', [
            'model' => $this->findModel($parent, $child),
        ]);
    }

    /**
     * Creates a new AuthItemChild model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(\Yii::$app->user->can('admin_mod')){

            $model = new AuthItemChild();
            $parent = Yii::$app->request->get('parent');


            $items = AuthItem::find()
                ->Where(['type'=>2])
                ->select("name")
                ->all();

            $result = [];
            foreach($items as $item){
                $auth =  Yii::$app->authManager;
                $aux_rol = $auth->createRole($parent);
                $aux_permiso= $auth->createPermission($item->name);
                if(!$auth->hasChild($aux_rol,$aux_permiso)){
                    // array_push($result,$aux_permiso);
                    $result [] = $item;
                }
            }

            $model->parent = $parent;
            if ($model->load(Yii::$app->request->post())) {

                $auth =  Yii::$app->authManager;

                $rol = $auth->createRole($parent);
                $permiso = $auth->createPermission($model->child);

                if($auth->hasChild($rol,$permiso)){
                    $model->addError('error', 'El rol actual ya contiene el permiso especificado.');
                }
                if( $auth->getPermission($permiso->name)== null ){
                    $model->addError('error', 'No existe el permiso especificado.');
                }

                if (!$model->hasErrors())
                {
                    $auth->addChild($rol,$permiso);
                    return $this->redirect(['index']);
                }

            }

            return $this->render('create', [
                'model' => $model, 'items'=> $result
            ]);

        }else{
            throw new ForbiddenHttpException('Acceso denegado');
        }

    }

    /**
     * Updates an existing AuthItemChild model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $parent
     * @param string $child
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($parent, $child)
    {
        if(\Yii::$app->user->can('admin_mod')){

            $model = $this->findModel($parent, $child);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'parent' => $model->parent, 'child' => $model->child]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);

        }else{
            throw new ForbiddenHttpException('Acceso denegado');
        }


    }

    /**
     * Deletes an existing AuthItemChild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $parent
     * @param string $child
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($parent, $child)
    {
        if(\Yii::$app->user->can('admin_mod')){

        }else{
            throw new ForbiddenHttpException('Acceso denegado');
        }

        $this->findModel($parent, $child)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItemChild model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $parent
     * @param string $child
     * @return AuthItemChild the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($parent, $child)
    {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



/*
    public function actionPermisos($term,$rol){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $roles = AuthItem::find()
            ->where(['like','name',$term])
            ->andWhere(['type'=>2])
            ->select("name")
            ->all();

        $result = [];
        foreach($roles as $item){
            $auth =  Yii::$app->authManager;
            $aux_rol = $auth->createRole($rol);
            $aux_permiso= $auth->createPermission($item->name);
            if(!$auth->hasChild($aux_rol,$aux_permiso)){
               // array_push($result,$aux_permiso);
              $result [] = $item;
            }
        }


        if($result!=null)
            return $result;

        return false;
    }

*/

}
