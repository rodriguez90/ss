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
                        'actions' => ['logout', 'contact', 'about', 'index','register', 'print', 'report', 'printreport'],
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
        $user = Yii::$app->user->identity;
        $importCount = 0;
        $exportCount = 0;
        $session = Yii::$app->session;

        if($user && ($user->hasRol('Importador')  ||  $user->hasRol('Exportador') ||  $user->hasRol('Importador_Exportador')))
        {
            $agency = $user->getAgency();
            if($agency)
            {
                $session->set('agencyId', $agency->id);
                $importCount = Process::find()->where(['type'=>Process::PROCESS_IMPORT, 'agency_id'=>$agency->id])->count();
                $exportCount = Process::find()->where(['type'=>Process::PROCESS_EXPORT, 'agency_id'=>$agency->id])->count();
            }
        }
        else if ($user && $user->hasRol('Cia_transporte'))
        {
            $transcompany = $user->getTransCompany();
            if($transcompany)
            {
                $session->set('transCompanyId', $transcompany->id);
            }
        }
//        else if ($user && ($user->hasRol('Deposito') || $user->hasRol('Administrador_deposito')))
//        {
//            $warehouse = $user->getWhareHouse();
//            if($warehouse)
//            {
//                $searchModel->warehouseCompanyId = $warehouse->id;
//            }
//        }
        else if($user && $user->hasRol('Administracion'))
        {
            $importCount = Process::find()->where(['type'=>Process::PROCESS_IMPORT])->count();
            $exportCount = Process::find()->where(['type'=>Process::PROCESS_EXPORT])->count();
        }

        $myparams = array();
        $myparams['importCount'] = $importCount;
        $myparams['exportCount'] = $exportCount;
        $ticketCount = TicketSearch::find()->count(); // FIXME: FILTER TICKET BY ROLE
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
            if ($model->login())
            {
                $session = Yii::$app->session;
                $session->open();

                $user = Yii::$app->user->identity;
				
				$session->set('user', $user);
                return $this->redirect(Url::toRoute('/site/index'));
            }
            else
            {
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

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionPrint()
    {
        $processId = Yii::$app->request->get('process');
        $session = Yii::$app->session;

        $processExp = Process::find()
            ->innerJoin('agency','process.agency_id = agency.id')
            ->innerJoin('process_transaction','process_transaction.process_id = process.id')
            ->innerJoin('container','process_transaction.container_id = container.id')
            ->where(['process.type'=>Process::PROCESS_EXPORT])
            ->andWhere(['process.id'=>$processId])
            ->andFilterWhere(['agency_id'=>$session->get('agencyId')])
            ->andFilterWhere(['process_transaction.trans_company_id'=>$session->get('transCompanyId')])
            ->all();

        $processImp = Process::find()
            ->innerJoin('agency','process.agency_id = agency.id')
            ->innerJoin('process_transaction','process_transaction.process_id = process.id')
            ->innerJoin('container','process_transaction.container_id = container.id')
            ->where(['process.type'=>Process::PROCESS_IMPORT])
            ->andWhere(['process.id'=>$processId])
            ->andFilterWhere(['agency_id'=>$session->get('agencyId')])
            ->andFilterWhere(['process_transaction.trans_company_id'=>$session->get('transCompanyId')])
            ->all();

        $body = $this->renderPartial('print', [
            'processExp' => $processExp,'processImp'=>$processImp
            ,
        ]);

        $pdf =  new mPDF(['mode'=>'utf-8' , 'format'=>'A4-L']);
        $pdf->SetTitle("Solicitudes Realizadas");
        $pdf->WriteHTML($body);
        $path= $pdf->Output("Solicitudes Realizadas.pdf","I");

    }

    public function actionReport()
    {
        if(Yii::$app->request->post())
        {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $bl = Yii::$app->request->post("bl");
            $agencyId =  Yii::$app->request->post("agencyId");
            $transCompanyId =  Yii::$app->request->post("transCompanyId");

            $response = array();
            $response['success'] = true;
            $response['data'] = [];
            $response['msg'] = '';
            $response['msg_dev'] = '';

            try{

                $response['data'] = Process::find()
                    ->select('process.id, 
                                process.bl, 
                                process.delivery_date, 
                                process.type, 
                                agency.name as agencyName,
                                COUNT(process_transaction.id) as containerAmount,			 
                                COUNT(ticket.id) as countTicket'
                    )
                    ->innerJoin('agency', 'agency.id = process.agency_id')
                    ->innerJoin("process_transaction","process_transaction.process_id = process.id")
                    ->leftJoin("ticket","process_transaction.id = ticket.process_transaction_id")
                    ->where(['process.active'=>1, 'process_transaction.active'=>1])
                    ->andFilterWhere(['process.bl'=>$bl])
                    ->andFilterWhere(['agency_id'=>$agencyId])
                    ->andFilterWhere(['process_transaction.trans_company_id'=>$transCompanyId])
                    ->groupBy(['process.id', 'process.bl', 'process.delivery_date', 'process.type', 'agency.name'])
                    ->asArray()
                    ->all();

            }
            catch ( \PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido al recuperar los procesos.";
                    $response['msg_dev'] = $e->getMessage();
                }
            }

            return $response;
        }

        return $this->render('report');
    }

    public function actionPrintreport()
    {
        $processId = Yii::$app->request->get('process');

        $process = Process::find()->innerJoin('agency', 'agency.id = process.agency_id')
            ->innerJoin("process_transaction","process_transaction.process_id = process.id")
            ->where(['process_transaction.active'=>1])
            ->andWhere(['process.id'=>$processId])
            ->andWhere(['process.active'=>1])
            ->andWhere(["process_transaction.active"=>1])
            ->all();

        $result = [];

        foreach ($process as $p)
        {
            $row = [];
            $row["process"] = $p;
            $containers = Container::find()
                ->select('container.id,process_transaction.status,container.name,container.tonnage,process_transaction.id as process_trans_id')
                ->innerJoin("process_transaction","process_transaction.container_id = container.id")
                ->innerJoin("process","process_transaction.process_id = process.id")
                ->where(["process.id"=>$p->id])
                ->andWhere(["process_transaction.active"=>1])
                ->asArray()
                ->all();

            $contickes = [];
            foreach ($containers as $container)
            {
               $start_datetime  = ProcessTransaction::find()
                    ->select('calendar.start_datetime')
                    ->innerJoin("ticket","ticket.process_transaction_id = process_transaction.id")
                    ->innerJoin("calendar","calendar.id = ticket.calendar_id")
                    ->where(["process_transaction.id"=> $container['process_trans_id']])
                    ->andWhere(["process_transaction.active"=>1])
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
        $path= $pdf->Output("Solicitudes Realizadas.pdf","I");

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

    public function actionDashboardata()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['success'] = true;
        $response['data'] = [];
        $response['msg'] = '';
        $response['msg_dev'] = '';
        $session = Yii::$app->session;

        if($response['success'])
        {
            try{

                $response['data'] = Process::find()
                    ->select('process.id, 
                                    process.bl, 
                                    process.delivery_date, 
                                    process.type, 
                                    agency.name as agency_name,
                                    COUNT(process_transaction.id) as countContainer,			 
                                    COUNT(ticket.id) as countTicket'
                                )
                    ->innerJoin('agency', 'agency.id = process.agency_id')
                    ->innerJoin("process_transaction","process_transaction.process_id = process.id and process_transaction.active=1")
                    ->leftJoin("ticket","process_transaction.id = ticket.process_transaction_id and ticket.active=1")
                    ->where(['process.active'=>1])
                    ->andFilterWhere(['agency_id'=>$session->get('agencyId')])
                    ->andFilterWhere(['process_transaction.trans_company_id'=>$session->get('transCompanyId')])
                    ->groupBy(['process.id', 'agency.id'])
                    ->asArray()
                    ->all();

            }
            catch ( \PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido al recuperar los procesos.";
                    $response['msg_dev'] = $e->getMessage();
                }
            }
        }

        return $response;
    }

}
