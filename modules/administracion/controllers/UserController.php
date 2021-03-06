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


use yii\db\Exception;
use yii\filters\AccessControl;
use yii\rbac\Role;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use PDOException;

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
//                'only' => ['Getagencias', 'Getdeposito', 'Getagenciastrans'],
//                'except' => ['getagencias','getdeposito','getagenciastrans',],
                'rules' => [
//                    [
//                        'allow' => true,
//                        'actions' => ['Getagencias','Getdeposito','Getagenciastrans',],
//                    ],
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
        $postData = Yii::$app->request->post();
//        var_dump($postData);die;

        if(!isset($postData['status']))
        {
            $postData['status']= 0;
        }

        if ($model->load($postData))
        {

            $rol = Yii::$app->request->post("rol");

            if( $model->password==''){
                $model->addError('error', 'La Contraseña no pueden ser vacía');
            }

            if( $confirm != null && $model->password != $confirm){
                $model->addError('error', 'Las contraseñas no son iguales.');
            }

            if( $rol == null ||  $auth->getRole($rol) == null){
                $model->addError('error', "Seleccione un rol válido." );
            }
            else{
                $type = Yii::$app->request->post("type");
                switch($rol){
                    case 'Importador':
                    case 'Exportador':
                    case "Importador_Exportador":
                    case 'Agencia':
                        if($type == '')
                            $model->addError('error', "Seleccione una empresa." );
                        break;
                    case 'Administrador_deposito':
                    case 'Deposito':
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

            if(AdmUser::findOne(['username'=>$model->username]) != null){

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
                        case "Importador_Exportador":
                        case 'Agencia':
                            $userAgency = new UserAgency();
                            $userAgency->user_id = $model->id;
                            $userAgency->agency_id = $type;
                            $userAgency->save();
                            break;
                        case 'Administrador_deposito':
                        case 'Deposito':
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
        throw new ForbiddenHttpException('Esta vista no esta disponible.');

        if ( \Yii::$app->user->can('user_update') || \Yii::$app->user->getId() == $id  ) {

            $transaction = Yii::$app->db->beginTransaction();

            try{
                $model = $this->findModel($id);
                if($model !== null){

                    $old_password = $model->password;
                    $auth =  Yii::$app->authManager;
                    $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];
                    $status = Yii::$app->request->post('status');

                    $rol = '';
                    $type = -1;
                    $error = '';
                    $type_actual=-1;
                    $change_rol = false;
                    $ok = true;

                    $rol_actual = $auth->getRole($model->getRole());

                    $modelAux = null;
                    $modelAuxId = '';
                    $modelAuxName = '';
                    switch($rol_actual->name){
                        case 'Importador':
                        case 'Exportador':
                        case "Importador_Exportador":
                        case 'Agencia':
                            $error  = "Seleccione una agencia.";
                            $modelAux = UserAgency::findOne(['user_id'=>$model->id]);
                            if($modelAux)
                            {
                                $type_actual = $modelAux->agency_id;
                                $modelAuxId = $modelAux->agency->id;
                                $modelAuxName = $modelAux->agency->name;
                            }
                            break;
                        case 'Administrador_deposito':
                        case 'Deposito':
                            $error  ="Seleccione un depósito." ;
                            $modelAux = UserWarehouse::findOne(['user_id'=>$model->id]);
                            if($modelAux)
                            {
                                $type_actual = $modelAux->warehouse_id;
                                $modelAuxId = $modelAux->warehouse->id;
                                $modelAuxName = $modelAux->warehouse->name;
                            }
                            break;
                        case 'Cia_transporte':
                            $error  ="Seleccione una compañía de transporte.";
                            $modelAux = UserTranscompany::findOne(['user_id'=>$model->id]);
                            if($modelAux)
                            {
                                $type_actual = $modelAux->transcompany_id;
                                $modelAuxId = $modelAux->transcompany->id;
                                $modelAuxName = $modelAux->transcompany->name;
                            }
                            break;
                        default :
                            break;
                    }

                    if ($model->load(Yii::$app->request->post()) ) {

                        $rol = Yii::$app->request->post("rol");
                        $type = Yii::$app->request->post("type");

                        if( $rol==null ||  $auth->getRole($rol) ==null){
                            $model->addError('error', "Seleccione un rol válido." );
                        }

                        if($type == "" && $rol_actual->name != "Administracion" && $rol != "Administracion" ){
                            $model->addError('error', $error );
                        }

                        if (!$model->hasErrors())
                        {
                            if($model->password !== '')
                            {
                                $model->setPassword($model->password);
                            }
                            else
                                $model->password = $old_password;

                            $model->updated_at = time();

                            if(Yii::$app->user->getId() == $id )
                            {
                                $model->status = 1 ;
                            }
                            else
                            {
                                if($status == null)
                                    $model->status = 0 ;
                                else
                                    $model->status = 1 ;
                            }


                            if ($model->save())
                            {
                                $new_rol = $auth->createRole($rol);

                                if($rol_actual == null){
                                    $ok = $ok && $auth->assign($new_rol,$model->id);
                                }else if(  $new_rol->name != $rol_actual->name ){
                                    $ok = $ok && $auth->revoke($rol_actual,$model->id);
                                    if($ok)
                                        $ok = $ok && $auth->assign($new_rol,$model->id);
                                    $change_rol= true;
                                }

                                switch($rol){
                                    case "Importador":
                                    case "Exportador":
                                    case "Importador_Exportador":
                                    case "Agencia":
                                        if($change_rol){
                                            $userAgency = new UserAgency();
                                            $userAgency->agency_id = $type;
                                            $userAgency->user_id = $model->id;

                                            $ok = $ok && $userAgency->save();
                                            if($modelAux != null)
                                                $modelAux->delete();
                                        }else{
                                            $userAgency = UserAgency::findOne(['user_id'=>$model->id]);
                                            $userAgency->agency_id = $type;
                                            $ok = $ok && $userAgency->update();
                                        }
                                        break;
                                    case "Administrador_deposito":
                                    case "Deposito":
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
                                            if($userTrans)
                                            {
                                                $userTrans->transcompany_id = $type;

                                                $ok = $ok && $userTrans->update();
                                            }
                                        }
                                        break;
                                    default :
                                        if($modelAux != null){
                                            $modelAux->delete();
                                        }
                                        break;
                                }
                            }
                        }
                        try
                        {
                            if($ok) {
                                $transaction->commit();
//                                return $this->redirect(['index']);
                                return $this->redirect(Yii::$app->request->referrer ? Yii::$app->request->referrer: Yii::$app->homeUrl);
                            }else{
                                $transaction->rollBack();
                            }
                        }
                        catch (PDOException $exception)
                        {

                            if($exception->getCode() !== '01000')
                            {
                                $model->addError('error', 'Ah ocurrido un error en el servidor.' );
                            }
                            else{
                                return $this->redirect(['index']);
                            }
                        }
                    }
                }else{
                    $model->addError('error', "No existe el usuario" );
                }
            }
            catch (Exception $e)
            {
                if($e->getCode() !== '01000')
                {
                    $model->addError('error', 'Ah ocurrido un error en el servidor.' );
                }
                else{
                    return $this->redirect(['index']);
                }
            }

            $roles  = $auth->getRoles();

//            var_dump($modelAuxId);
//            var_dump($modelAuxName);die;

            return $this->render('update', [
                'model' => $model,
                'rol_actual'=>$rol_actual->name,
                'roles'=>$roles,
                'type'=>$type_actual,
                'modelAux'=>['id'=>$modelAuxId,  'name'=>utf8_encode($modelAuxName)]
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
            if($model)
            {
                $model->status = -1;
                $model->save();
            }
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
        $model = AdmUser::find()
            ->where(['id'=>$id])
            ->andWhere(['<>', 'status',-1])
            ->one();

        if ($model  !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El usuario no existe.');
    }

    public function actionGetagencias(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['objects'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            $sql = "exec sp_sgt_empresa_cons '" . $code . "'";
            $results = Yii::$app->db3->createCommand($sql)->queryAll();

            try{
                $trasaction = Yii::$app->db->beginTransaction();
                $doCommit = false;

                foreach ($results as $result)
                {
                    $agency = Agency::findOne(['ruc'=>$result['rutempresa']]);

                    if($agency === null)
                    {
                        $doCommit = true;
                        $agency = new Agency();
                        $str = utf8_decode($result['nombre']);
                        $agency->name = $str;
                        $agency->ruc = $result['rutempresa'];
                        $agency->code_oce = '';
                        $agency->active = 1;

                        if(!$agency->save(false))
                        {
                            $response['success'] = false;
                            $response['msg'] = "Ah ocurrido un error al buscar las Empresas.";
                            $response['msg_dev'] = implode(' ', $agency->getErrors(false));
                            break;
                        }
                    }
                    else {
                        $str = utf8_encode($agency->name);
                        $agency->name = $str;
                    }
                    $response['objects'][] = $agency;
                }

                if($response['success'])
                {
                    if($doCommit)
                        $trasaction->commit();
                }
                else
                {
                    $trasaction->rollBack();
                }
            }
            catch ( \PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al buscar las Empresas de Transporte.";
                    $response['msg_dev'] = $e->getMessage();
                    $trasaction->rollBack();
                }
            }
        }
        return $response;
    }

    public function actionGetdeposito(){

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['objects'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el nombre.";
        }

        try
        {
            $response['objects'] = Warehouse::find()
                ->where(['active'=>1])
                ->andFilterWhere(['like','name', $code])
                ->all();
        }
        catch (Exception $ex)
        {
            $response['success'] = false;
            $response['objects'] = [];
            $response['msg'] = 'Ah ocurrido un error al buscar los depositos';
            $response['msg_dev'] = $ex->getMessage();
        }

        return $response;
    }

    public function actionGetagenciastrans()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['objects'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        $code = Yii::$app->request->get('code');

        if(!isset($code))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el código de búsqueda.";
        }

        if($response['success'])
        {
            $sql = "exec sp_sgt_companias_cons '" . $code . "'";
            $results = Yii::$app->db2->createCommand($sql)->queryAll();

            try{
                $trasaction = TransCompany::getDb()->beginTransaction();
                $doCommit = false;

                foreach ($results as $result)
                {
                    $t = TransCompany::findOne(['ruc'=>$result['ruc_empresa']]);

                    if($t === null)
                    {
                        $doCommit = true;
                        $t = new TransCompany();
                        $str = utf8_decode($result['nombre_empresa']);
                        $t->name = $str;
                        $t->ruc = $result['ruc_empresa'];
                        $t->address = "NO TIENE";
                        $t->active = 1;

                        if(!$t->save())
                        {
                            $response['success'] = false;
                            $response['msg'] = "Ah ocurrido un error al buscar las Empresas de Transporte.";
                            $response['msg_dev'] = implode(' ', $t->getErrors(false));
                            break;
                        }
                    }
                    else {
                        $str = utf8_encode($t->name);
                        $t->name = $str;
                    }
                    $response['objects'][] = $t;
                }

                if($response['success'])
                {
                    if($doCommit)
                        $trasaction->commit();
                }
                else
                {
                    $trasaction->rollBack();
                }
            }
            catch ( \PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al buscar las Empresas de Transporte.";
                    $response['msg_dev'] = $e->getMessage();
                    $trasaction->rollBack();
                }
            }
        }
        return $response;;
    }

    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['data'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';

        if($response['success'])
        {
            try
            {
                $results = AdmUser::find()
                    ->select('adm_user.id, 
                                    adm_user.username, 
                                    adm_user.nombre, 
                                    adm_user.apellidos, 
                                    adm_user.email, 
                                    adm_user.created_at, 
                                    adm_user.status, 
                                    auth_assignment.item_name as role')
                    ->leftJoin('auth_assignment', 'auth_assignment.user_id=adm_user.id')
                    ->where(['<>','status',-1])
//                    ->groupBy(['adm_user.id']) // FIXME: CHECK THIS
                    ->asArray()
                    ->all();

                foreach ($results as $result)
                {
                    $result['nombre'] = utf8_encode($result['nombre']);
                    $result['apellidos'] = utf8_encode($result['apellidos']);
                    $result['created_at'] = date('Y/m/d',$result['created_at']);
                    $response['data'][] = $result;
                }
            }
            catch ( \PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido al recuperar las empresas.";
                    $response['msg_dev'] = $e->getMessage();
                }
            }
        }

        return $response;
    }
}
