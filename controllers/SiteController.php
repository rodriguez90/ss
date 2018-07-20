<?php

namespace app\controllers;

use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Agency;
use app\modules\rd\models\Container;
use app\modules\rd\models\Process;
use app\modules\rd\models\ProcessSearch;
use app\modules\rd\models\ProcessTransaction;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionSearch;
use app\modules\rd\models\ReceptionTransaction;
use app\modules\rd\models\Ticket;
use app\modules\rd\models\TicketSearch;
use app\modules\rd\models\TransCompany;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\UserTranscompany;

use app\modules\rd\models\Warehouse;
use DateTime;
use DateTimeZone;

use PDO;

use Mpdf\Mpdf;
use Yii;
use yii\db\Command;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\db\Expression;

use Da\QrCode\QrCode;



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout', 'contact', 'about', 'index','register'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                   // 'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//
//        $sql =  '{ CALL  disv..sp_sgt_bl_cons (@BL =:BL)}' ;
//
//        $command = \Yii::app()->db->createCommand($sql);
//        $command->bindParam(":BL", 'HLCUMTR180305591', PDO::PARAM_STR);
//        $list = $command->queryAll();
//
//        var_dump($list);die;


//        $sql = "exec disv.sp_sgt_bl_cons 'HLCUMTR180305591";
//        $params = [':BL'=>'HLCUMTR180305591'];

        // sql query for calling the procedure
//        $sql = "exec disv..sp_sgt_bl_cons HLCUMTR180305591";
//        $sql = "exec sp_sgt_companias_cons 12917504";
//        $sql = "exec sp_sgt_placa_cons 12917504";
//        $result = Yii::$app->db2->createCommand($sql)->queryAll();
//        var_dump($result);die;
//
//        $result = \Yii::$app->db->createCommand($sql, $params)
//            ->execute();
//
//        var_dump($result);die;

//        $connection = Yii::$app->db;
//        $command = $connection->createCommand($sql);
//        $result = $command->execute();
//        var_dump($result);die;

//        $w = Warehouse::find()->all();
//        var_dump($w);die;
//        $w = new Warehouse();
//
//        $w->name = 'Test';
//        $w->code_oce = 'aaaa';
//        $w->ruc = '1111111111111';
//        $w->active = 1;
//        if (!$w->save())
//        {
//            var_dump($w->getFirstErrors());
//        }
//        else
//        {
//            var_dump($w->id);
//        }
//        die;
//
//        $agencia = new Agency();
//        $agencia->name = 'Test';
//        $agencia->code_oce = 'aaaa';
//        $agencia->ruc = 'adsasdasdasdasd';
//        $agencia->active = 1;
//        if (!$agencia->save())
//        {
//            var_dump($agencia->getFirstErrors());
//        }
//        else
//        {
//            var_dump($agencia->id);
//        }
//
////        $agencia = Agency::findOne(['id'=>new Expression("CONVERT(integer, 1)")]);
//        $agencia = Agency::findOne(['name'=>new Expression("CONVERT(varchar, 'aaaa')")]);
//        var_dump($agencia);die;
//        $agencia->name = 'YEESSSSS!!!!';
//        if ($agencia->save())
//        {
//            die('YESSS!!!');
//        }
//        else
//        {
//            var_dump($agencia->getFirstErrors());die;
//        }
//        return $this->render('index');

        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $params = Yii::$app->request->queryParams;
        if($user && ($user->hasRol('Importador')  ||  $user->hasRol('Exportador') ||  $user->hasRol('Importador_Exportador')))
        {
            $agency = $user->getAgency();
            $params['agency_id'] = '';
            if($agency)
            {
                $params['agency_id'] = $agency->name;
            }
        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $transcompany = $user->getTransCompany();
            $params['trans_company_id'] = '';
            if($transcompany)
            {
                $params['trans_company_id'] = $transcompany->name;
            }
        }

        $searchModel = new ProcessSearch();
        $dataProvider = $searchModel->search($params);
        $importCount = Process::find()->where(['type'=>Process::PROCESS_IMPORT])->count();
        $exportCount = Process::find()->where(['type'=>Process::PROCESS_EXPORT])->count();
        $ticketCount = TicketSearch::find()->count();
        $myparams = array();
        $myparams['searchModel'] = $searchModel;
        $myparams['dataProvider'] = $dataProvider;
        $myparams['importCount'] = $importCount;
        $myparams['exportCount'] = $exportCount;
        $myparams['ticketCount'] = $ticketCount;
        return $this->render('index', $myparams);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
//            var_dump($model->login());die;
            if ($model->login())
            {
                $session = Yii::$app->session;
                $session->open();

                $user = AdmUser::findOne(['id'=>Yii::$app->user->getId(),'status'=>1]);
                if($user != null){
                    $session->set('user',$user);
                    return $this->redirect(Url::toRoute('/site/index'));
                }
                else {
                    return $this->render('login', ['model' => $model,'msg'=>'Usuario inactivo, contacte al administrador.']);
                }
            }
            else
            {
//                var_dump($model->getErrors());die;
                return $this->render('login', ['model' => $model,'msg'=>implode('', $model->getErrorSummary(false))]);
            }

        }
        else{
            $msg = 'Debe ingresar el usurio y la contraseña.';
            return $this->render('login', ['model' => $model,'msg'=>implode('', $model->getErrorSummary(false))]);
        }
    }


    public function actionRegister()
    {
        $this->layout = '@app/views/layouts/login';
        $confirm = Yii::$app->request->post('AdmUser')["passwordConfirm"];
        $usertype =  Yii::$app->request->post('usertype');
        $usertypeid =  Yii::$app->request->post('usertypeid');

        $model = new AdmUser();
        $modelLogin = new LoginForm();

        $agencias = Agency::findAll(['active'=>1]);
        $trans_comp = TransCompany::findAll(['active'=>1]);


        if ($model->load(Yii::$app->request->post() )  ) {

            if( $model->password==''){
                $model->addError('error', 'La Contraseña no pueden ser vacía');
            }

            if( $confirm!=null && $model->password != $confirm){
                $model->addError('error', 'Las contraseñas no son iguales.');
            }
            if(AdmUser::findOne(['username'=>$model->username])!=null){
                $model->addError('error', "Ya existe el nombre de usuario." );
            }

            if (AdmUser::findOne(['cedula' => $model->cedula]) != null)
            {
                $model->addError('error', "La cédula {$model->cedula} ya fue registrada en el sistema" );
            }

            if (!$model->hasErrors()) {
                $model->setPassword($model->password);
                $model->created_at = time();
                $model->updated_at = time();
                $model->creado_por = Yii::$app->user->identity->username;
                $model->status = 0;

                $auth =  Yii::$app->authManager;
                $new_rol = null;
                $ok = true;
                $msg = '';


                if ($model->save() && $usertype!=null && $usertypeid!=null) {

                    switch ($usertype){
                        case '1':
                        case '2':
                        case '3':
                            $user_agency = new UserAgency();
                            $user_agency->user_id = $model->id;
                            $user_agency->agency_id = $usertypeid;
                            $user_agency->save();
                            $roleName  = '';
                            if($usertype == '1')
                            {
                                $roleName = 'Importador';
                            }
                            elseif ($usertype == '2')
                            {
                                $roleName = 'Exportador';
                            }
                            elseif ($usertype == 3)
                            {
                                $roleName = 'Importador_Exportador';
                            }
                            $new_rol = $auth->createRole($roleName);
                            break;
                        case '4':
                            $user_trans = new UserTranscompany();
                            $user_trans->user_id = $model->id;
                            $user_trans->agency_id = $usertypeid;
                            $user_trans->save();
                            $new_rol = $auth->createRole("Cia_transporte");
                            break;
                        default:
                            break;
                    }

                    $ok = $ok && $auth->assign($new_rol,$model->id);
                    if($ok){
                        $msg = "Usuario registrado correctamente, espere a ser activado.";
                    }else{
                        $msg = "Ah ocurrido un error en el registro.";
                    }

                    return $this->redirect (['site/login','msg'=>$msg]);
                }
            }
        }


        return $this->render('register', ['model'=>$model,'agencias'=>$agencias,'trans_comp'=>$trans_comp]);
    }



    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if(Yii::$app->user->logout())
            return $this->redirect(Url::toRoute('/site/login') );
        //return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**                */
    public function actionAbout()
    {
        $containers = Container::find()
            ->all();


        return $this->render('about',['containers'=>$containers]);
    }

    public function actionQr(){

//    var_dump(date('YmdHis'));die;
       return $this->render('about', [
                "path"=> Yii::$app->request->baseUrl."/qrcodes/1-qrcode.png"
            ]);

    }


    public function actionPrint(){
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $params = Yii::$app->request->queryParams;
        if($user && $user->hasRol('Agencia'))
        {
            $userAgency = UserAgency::findOne(['user_id'=>$user->id]);
            $params['agency_id'] = '';
//            if($userAgency)
//            {
//                $params['agency_id'] = $userAgency->agency->name;
//            }
        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $userCiaTrans = UserTranscompany::findOne(['user_id'=>$user->id]);
            $params['trans_company_id'] = '';
            if($userCiaTrans)
            {
                $params['trans_company_id'] = $userCiaTrans->transcompany->name;
            }
        }

        $processExp = Process::find()
            ->innerJoin('agency','process.agency_id = agency.id')
            ->innerJoin('process_transaction','process_transaction.process_id = process.id')
            ->innerJoin('container','process_transaction.container_id = container.id')
            ->where(['process.type'=>Process::PROCESS_EXPORT])

            ->all();

        $processImp = Process::find()
            ->innerJoin('agency','process.agency_id = agency.id')
            ->innerJoin('process_transaction','process_transaction.process_id = process.id')
            ->innerJoin('container','process_transaction.container_id = container.id')
            ->where(['process.type'=>Process::PROCESS_IMPORT])

            ->all();

        $body = $this->renderPartial('print', [
            'processExp' => $processExp,'processImp'=>$processImp
            ,
        ]);

        $pdf =  new mPDF(['mode'=>'utf-8' , 'format'=>'A4-L']);
        $pdf->SetTitle("Solicitudes Realizadas");
        $pdf->WriteHTML($body);
        $path= $pdf->Output("Solicitudes Realizadas.pdf","D");

    }

    public function actionReport()
    {

//        if(!Yii::$app->user->can("admin_mod") && Yii::$app->user->can("process_create")) {
//            throw new ForbiddenHttpException('Usted no tiene permiso para crear una recepción');
//        }

        $trans_company = TransCompany::findAll(["active"=>1]);
        $agency = Agency::findAll(["active"=>1]);
        $process = Process::find()
            ->all();

        $searchModel = null;
        $dataProvider = null;

        if(Yii::$app->request->isPost){

            $params = Yii::$app->request->queryParams;
            $searchModel = new ProcessSearch();
            $dataProvider = $searchModel->search($params);

            $search_bl = Yii::$app->request->post("bl");
            $search_agency_id =  Yii::$app->request->post("agency_id");
            $search_trans_company =  Yii::$app->request->post("trans_company");

            if(isset($search_bl)) {
                $dataProvider->query->andFilterWhere(['like', 'bl', $search_bl]);
            }

            if(isset($search_agency_id)) {
                $dataProvider->query->andFilterWhere(['like', 'agency_id', $search_agency_id]);
            }

            if(isset($search_trans_company)) {
                    $filter = ProcessTransaction::find()->select('process_id')->where(['like','trans_company_id', $search_trans_company]);
                    $dataProvider->query->andFilterWhere(['process.id'=>$filter]);
            }
        }

        return $this->render('report', [
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'trans_company'=>$trans_company,
            'agency'=>$agency,
             'process'=>$process,
             'search_bl'=>$search_bl,
            'search_agency_id'=>$search_agency_id,
            'search_trans_company'=>$search_trans_company,

        ]);
    }

    public function actionPrintreport($bl,$agency_id,$trans_company_id){

        $process = Process::find()->innerJoin('agency', 'agency.id = process.agency_id')
            ->innerJoin("process_transaction","process_transaction.process_id = process.id")
            ->where(['like', 'bl', $bl])
            ->andWhere(['like', 'agency_id', $agency_id])
            ->andWhere( ['like','process_transaction.trans_company_id',$trans_company_id])
            ->all();

        $result = [];

        foreach ($process as $p){

            $row = [];
            $row["process"] = $p;
            $containers = Container::find()
                ->select('container.id,container.status,container.name,container.tonnage,process_transaction.id as process_trans_id')
                ->innerJoin("process_transaction","process_transaction.container_id = container.id")
                ->innerJoin("process","process_transaction.process_id = process.id")
                ->where(["process.id"=>$p->id])
                ->asArray()
                ->all();



            $contickes = [];
            foreach ($containers as $container){
               $start_datetime  = ProcessTransaction::find()
                    ->select('calendar.start_datetime')
                    ->innerJoin("ticket","ticket.process_transaction_id = process_transaction.id")
                    ->innerJoin("calendar","calendar.id = ticket.calendar_id")
                    ->where(["process_transaction.id"=> $container['process_trans_id']])
                    ->asArray()
                    ->one();


               if($start_datetime['start_datetime']!=''){
                   $contickes [] = array_merge($container,$start_datetime);
               }else{
                   $contickes [] =  array_merge($container,['start_datetime'=>'']);
               }
            }

            $row["containers"] = $contickes;
            $result [] = $row;
        }


        $body = $this->renderPartial('print_report',
            ['result'=>$result]);

        $pdf =  new mPDF(['mode'=>'utf-8' , 'format'=>'A4-L']);
        $pdf->SetTitle("Solicitudes Realizadas");
        $pdf->WriteHTML($body);
        $path= $pdf->Output("Solicitudes Realizadas.pdf","D");

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
}
