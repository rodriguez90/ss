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
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;
use app\modules\rd\models\UserWarehouse;


use Faker\Provider\UserAgent;
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
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
        if ( \Yii::$app->user->can('user_list')) {

            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            throw new ForbiddenHttpException('Acceso denegado');
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('user_view') || \Yii::$app->user->getId() == $id ) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{
            throw new ForbiddenHttpException('Acceso denegado');
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        if ( \Yii::$app->user->can('user_create')) {

        $auth =  Yii::$app->authManager;
        $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];
        $model = new AdmUser();
        $rol = '';
        $type = -1;

        if ($model->load(Yii::$app->request->post()) ) {

        $rol = Yii::$app->request->post("rol");

        if( $model->password==''){
            $model->addError('error', 'La Contraseña no pueden ser vacía');
        }

        if( $confirm!=null && $model->password != $confirm){
            $model->addError('error', 'Las contraseñas no son iguales.');
        }

        if( $rol==null ||  $auth->getRole($rol) ==null){
            $model->addError('error', "Seleccione un rol válido." );
        }else{
            $type = Yii::$app->request->post("type");
            switch($rol){
                case 'Importador':
                case 'Exportador':
                case 'Agencia':
                    if($type == '')
                        $model->addError('error', "Seleccione una agencia." );
                    break;
                case 'Administrador_depósito':
                    if($type == '')
                    $model->addError('error', "Seleccione un depósito." );
                    break;
                case 'Depósito':
                    if($type == '')
                        $model->addError('error', "Seleccione un depósito." );
                    break;
                case 'Cia_transporte':
                    if($type == '')
                    $model->addError('error', "Seleccione una compañía de transporte." );
                    break;
                default :
                    break;
            }
        }

        if(AdmUser::findOne(['username'=>$model->username])!=null){
            $model->addError('error', "Ya existe el nombre de usuario." );
        }

        if (AdmUser::findOne(['cedula' => $model->cedula]) != null)
            {
                $model->addError('error', "La cédula {$model->cedula} ya fue registrada en el sistema" );
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

                    //cambiar la comparacion a minuscula
                    switch($rol){
                        case 'Importador':
                        case 'Exportador':
                        case 'Agencia':
                            $userAgency = new UserAgency();
                            $userAgency->user_id = $model->id;
                            $userAgency->agency_id = $type;
                            $userAgency->save();
                            break;
                        case 'Administrador_depósito':
                            $userWarehouse = new UserWarehouse();
                            $userWarehouse->user_id = $model->id;
                            $userWarehouse->warehouse_id = $type;
                            $userWarehouse->save();
                            break;
                        case 'Depósito':
                            $userWarehouse = new UserWarehouse();
                            $userWarehouse->user_id = $model->id;
                            $userWarehouse->warehouse_id = $type;
                            $userWarehouse->save();
                            break;
                        case 'Cia_transporte':
                            $userTrans = new UserTranscompany();
                            $userTrans->user_id = $model->id;
                            $userTrans->transcompany_id = $type;
                            $userTrans->save();
                            break;
                        default :
                            break;
                    }

                    return $this->redirect(['index', 'id' => $model->id]);
                }
            }
        }

        $roles  = $auth->getRoles();

        return $this->render('create', [ 'model' => $model,'roles'=>$roles,'rol_actual'=>$rol,'type'=>$type]);

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

        if ( \Yii::$app->user->can('user_update') || \Yii::$app->user->getId() == $id  ) {


            $transaction = \Yii::$app->db->beginTransaction();

            $model = $this->findModel($id);
            if($model!=null){

                $old_password = $model->password;
                $auth =  Yii::$app->authManager;
                $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];
                $rol = '';
                $type = -1;
                $error = '';
                $type_actual=-1;
                $change_rol = false;
                $ok = true;

                $rol_actual = $auth->getRole($model->getRole());

               // var_dump($rol_actual);

                $modelAux=null;
                switch($rol_actual->name){
                    case 'Importador':
                    case 'Exportador':
                    case 'Agencia':
                        $error  = "Seleccione una agencia.";
                        $modelAux = UserAgency::findOne(['user_id'=>$model->id]);
                        if($modelAux)
                            $type_actual = $modelAux->agency_id;
                        break;
                    case 'Administrador_depósito':
                    case 'Depósito':
                        $error  ="Seleccione un depósito." ;
                        $modelAux = UserWarehouse::findOne(['user_id'=>$model->id]);
                        if($modelAux)
                            $type_actual = $modelAux->warehouse_id;
                        break;
                    case 'Cia_transporte':
                        $error  ="Seleccione una compañía de transporte.";
                        $modelAux = UserTranscompany::findOne(['user_id'=>$model->id]);
                        if($modelAux)
                            $type_actual = $modelAux->transcompany_id;
                        break;
                    default :
                        break;
                }

                //var_dump($error);
                //var_dump($type_actual);


                if ($model->load(Yii::$app->request->post()) ) {

                    $rol = Yii::$app->request->post("rol");
                    $type = Yii::$app->request->post("type");




                    if( $rol==null ||  $auth->getRole($rol) ==null){
                        $model->addError('error', "Seleccione un rol válido." );
                    }

                    if($type =="" && $rol_actual->name!="Administracion" && $rol!="Administracion" ){
                        $model->addError('error', $error );

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

                            if(  $new_rol->name != $rol_actual->name ){
                                $ok = $ok && $auth->revoke($rol_actual,$model->id);
                                if($ok)
                                    $ok = $ok && $auth->assign($new_rol,$model->id);
                                $change_rol= true;
                            }




/*

                                var_dump($rol);
                                echo "<br></br>";
                                var_dump($type);
                                echo "<br></br>";
                                var_dump($type_actual);
                                echo "<br></br>";
                                var_dump($modelAux);
                                echo "<br></br>";
                                var_dump($change_rol);
                                echo "<br></br>";
                                var_dump($model->id);
                                echo "<br></br>";
                                var_dump($ok);
                                echo "<br></br>";


                                die;

*/

                                switch($rol){
                                    case "Importador":
                                    case "Exportador":
                                    case "Agencia":
                                        if($change_rol){
                                            $userAgency = new UserAgency();
                                            $userAgency->agency_id = $type;
                                            $userAgency->user_id = $model->id;



                                            $ok = $ok && $userAgency->save();
                                            if($modelAux!=null)
                                                $modelAux->delete();
                                        }else{
                                            $userAgency = UserAgency::findOne(['user_id'=>$model->id]);
                                            $userAgency->agency_id = $type;
                                            $ok = $ok && $userAgency->update();
                                        }
                                        break;
                                    case "Administrador_depósito":
                                    case "Depósito":
                                        if($change_rol){
                                            $userWarehouse = new UserWarehouse();
                                            $userWarehouse->warehouse_id = $type;
                                            $userWarehouse->user_id =$model->id;
                                            $ok = $ok && $userWarehouse->save();
                                            if($modelAux != null)
                                                $modelAux->delete();
                                        }else{
                                            $userWarehouse = UserWarehouse::findOne(['user_id'=>$model->id]);
                                            $userWarehouse->warehouse_id = $type;
                                            $ok = $ok && $userWarehouse->update();
                                        }

                                        break;
                                    case "Cia_transporte":
                                        if($change_rol){
                                            $userTrans = new UserTranscompany();
                                            $userTrans->user_id=$model->id;
                                            $userTrans->transcompany_id = $type;
                                            $ok = $ok && $userTrans->save();
                                            if($modelAux!=null)
                                                $modelAux->delete();
                                        }else{
                                            $userTrans = UserTranscompany::findOne(['user_id'=>$model->id]);
                                            $userTrans->transcompany_id = $type;

                                            $ok = $ok && $userTrans->update();
                                        }
                                        break;
                                    default :
                                        if($modelAux!=null){
                                            $modelAux->delete();
                                        }
                                        break;
                                }


                            if($ok) {
                                $transaction->commit();
                            }else{
                                $transaction->rollBack();
                            }

                            return $this->redirect(['index']);
                        }

                    }else{
                        $transaction->rollBack();
                    }

                }

            }else{
                $model->addError('error', "No existe el usuario" );
            }

            $roles  = $auth->getRoles();

            return $this->render('update', [
                'model' => $model,'rol_actual'=>$rol_actual->name,'roles'=>$roles,'type'=>$type_actual
            ]);

        }else{
            throw new ForbiddenHttpException('Acceso denegado');
        }

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
        $model = $this->findModel($id);
        if (  \Yii::$app->user->can('user_delete') &&  $model->username != 'root' && $model->username != \Yii::$app->user) {
            //return $this->redirect(['create']);
            $this->findModel($id)->delete();
        }

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

    public function actionGetagencias(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = Agency::find()
            ->all();

        if($result!=null)
            return $result;

        return false;

    }

    public function actionGetdeposito(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = Warehouse::find()
            ->all();

        if($result!=null)
            return $result;

        return false;

    }

    public function actionGetagenciastrans(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $result = TransCompany::find()
            ->all();

        if($result!=null)
            return $result;

        return false;

    }
}
