<?php

namespace app\modules\administracion\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\administracion\models\AdmuserSearch;
use app\modules\administracion\models\AuthAssignment;
use app\modules\administracion\models\AuthItem;
use app\modules\administracion\models\UserSearch;
use app\modules\rd\models\Agency;
use app\modules\rd\models\Warehouse;
use app\modules\rd\models\TransCompany;

use Yii;


use yii\filters\AccessControl;
use yii\rbac\Role;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        if ( \Yii::$app->user->can('User_create')) {

        $auth =  Yii::$app->authManager;
        $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];
        $model = new AdmUser();

        if ($model->load(Yii::$app->request->post()) ) {

        $rol = Yii::$app->request->post("rol");

        if( $confirm!=null && $model->password != $confirm){
            $model->addError('error', 'Las contraseñas no son iguales.');
        }

        if( $rol==null ||  $auth->getRole($rol) ==null){
            $model->addError('error', "Seleccione un rol válido." );
        }


        if (!$model->hasErrors())
            {
                $model->setPassword($model->password);
                $model->created_at = time();
                $model->updated_at = time();
                $model->creado_por = Yii::$app->user->identity->username;
                if ($model->save())
                {
                    $rol_user = $auth->createRole($rol);
                    $auth->assign($rol_user,$model->id);

                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }

        }

        return $this->render('create', [ 'model' => $model,'rol_actual'=>'']);

        }
        else{
            throw new ForbiddenHttpException('Acceso denegado');
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_password = $model->password;
        $auth =  Yii::$app->authManager;
        $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];

        $actual = AuthAssignment::find()
            ->innerJoin("adm_user","auth_assignment.user_id = adm_user.id")
            ->where(['adm_user.id'=>$model->id])
            ->one();


        $rol_actual = $auth->getRole($actual->item_name);

        if ($model->load(Yii::$app->request->post()) ) {

            $rol = Yii::$app->request->post("rol");

            if($rol ==null){
                $model->addError('error', 'Seleccione almenos un rol.');
            }

                if( $confirm!=null && $model->password != $confirm){
                    $model->addError('error', 'Las contraseñas no son iguales.');
                }


            if (!$model->hasErrors())
            {
                if($model->password!=""){
                    $model->setPassword($model->password);
                }else
                    $model->password = $old_password;

                $model->updated_at = time();

                if ($model->save())
                {
                    $new_rol = $auth->createRole($rol);

                    if(  $new_rol->name!= $rol_actual->name ){
                        $auth->revoke($rol_actual,$model->id);
                        $auth->assign($new_rol,$model->id);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }

        }

        return $this->render('update', [
            'model' => $model,'rol_actual'=>$rol_actual->name
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdmUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




    public function actionGetagencias($term){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = Agency::find()->where(['like','name',$term])
            ->select("name")
            ->all();

        if($result!=null)
            return $result;

        return false;

    }





    public function actionGetdeposito($term){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = Warehouse::find()->where(['like','name',$term])
            ->select("name")
            ->all();

        if($result!=null)
            return $result;

        return false;

    }



    public function actionGetagenciastrans($term){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = TransCompany::find()->where(['like','name',$term])
            ->select("name")
            ->all();

        if($result!=null)
            return $result;

        return false;

    }



}
