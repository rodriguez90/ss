<?php

namespace app\modules\rd\controllers;


use app\modules\rd\models\ContainerType;
use app\modules\rd\models\Line;
use app\modules\rd\models\TransCompany;
use app\modules\rd\models\Ticket;
use DateTime;
use DateTimeZone;
use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Container;
use app\modules\rd\models\Process;
use app\modules\rd\models\UserAgency;
use app\modules\rd\models\ContainerSearch;
use app\modules\rd\models\ProcessTransaction;
use QRcode;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use Mpdf\Mpdf;

use yii\web\Response;

/**
 * ProcessController implements the CRUD actions for Process model.
 */
class ProcessController extends Controller
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
                    'transactions' => ['GET'],
                    'containers' => ['GET'],
                    'Sgtblcons' => ['GET'],
                    'Sgtbookingcons'=>['GET']
                ],
            ],
        ];
    }

//    /**
//     * Lists all Process models.
//     * @return mixed
//     */
//    public function actionIndex()
//    {
//        if(!Yii::$app->user->can("process_list"))
//            throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');
//
//        $searchModel = new ProcessSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * Displays a single Process model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can("process_view")) // FIXME: change permission to process_view
            throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');

        $model = $this->findModel($id);
        $user = Yii::$app->user->identity;

        if($user && $user->hasRol('Agencia')) // FIXME: change role to Importer/Exporter
        {
            $userAgency = UserAgency::findOne(['user_id'=>Yii::$app->user->id]);
            if($userAgency && $userAgency->agency_id !== $model->agency_id)
                throw new ForbiddenHttpException('Usted no tiene acceso a este proceso');

        }
        else if ($user && $user->hasRol('Cia_transporte')){
            $userCiaTrans = UserTranscompany::findOne(['user_id'=>Yii::$app->user->id]);
            if($userCiaTrans && $userCiaTrans->transcompany_id !== $model->trans_company_id)
                throw new ForbiddenHttpException('Usted no tiene acceso a este proceso');
        }

        $query = ProcessTransaction::find()
                ->innerJoin('container', 'process_transaction.container_id = container.id')
                ->innerJoin('process', 'process_transaction.process_id = process.id')
                ->where(['process.id'=>$id, 'process_transaction.active'=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
//            'sort' => [
//                'defaultOrder' => [
//                    'process_transaction.id' => SORT_ASC,
//                ]
//            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider,
//            'searchModel'=>$searchModel ,
        ]);
    }

    /**
     * Creates a new Process model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {

        if((int)$type !== Process::PROCESS_IMPORT && (int)$type  !== Process::PROCESS_EXPORT)
            throw new ForbiddenHttpException('Error en el tipo de solicitud.');

        if(!Yii::$app->user->can("process_create"))
           throw new ForbiddenHttpException('Usted no tiene permiso para crear un proceso');

        $model = new Process();
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $userAgency = UserAgency::findOne(['user_id'=>$user->id]);

        $agency = null;
        if($userAgency)
        {
            $agency = $userAgency->agency;
        }
//        var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post())) {
            return $this->createProcess($model);
        }

        return $this->render('create', [
            'model' => $model,
            'type'=>$type,
//            'agency'=>$userAgency,
        ]);
    }

    /**
     * Updates an existing Process model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->can("process_update"))
            throw new ForbiddenHttpException('Usted no tiene permiso para actualizar un proceso');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Process model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can("process_delete"))
            throw new ForbiddenHttpException('Usted no tiene permiso para eliminar esta recepción');

        $model = $this->findModel($id);

        if($model)
        {
            $model->active = 0;
            $model->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Process model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Process the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Process::findOne(['id'=>$id, 'active'=>1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionContainers()
    {
//        if(!Yii::$app->user->can("process_list"))
//            throw new ForbiddenHttpException('Usted no tiene permiso para acceder a los procesos');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['msg'] = '';
        $response['containers'] = [];
        $response['success'] = false;
        $bl = Yii::$app->request->get('bl');

        if(isset($bl))
        {
            $response['containers'] = Container::find()
                ->innerJoin('process_transaction', 'process_transaction.container_id = container.id')
                ->innerJoin('process', 'process_transaction.process_id = process.id')
                ->where(['bl'=>$bl])
                ->all();
            $response['success'] = true;
        }
        else {
            $response['msg'] = "Tiene que especificar un código BL.";
        }

        return $response;
    }

    /**
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionTransactions()
    {
//        if(!Yii::$app->user->can("process_list"))
//            throw new ForbiddenHttpException('Usted no tiene permiso para acceder a los processos');

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response = array();
        $response['msg'] = '';
        $response['success'] = true;
        $response['transactions'] = [];
        $id = Yii::$app->request->get('id');
        $transCompanyId = Yii::$app->request->get('transCompanyId');
        $actived = Yii::$app->request->get('actived');

        if(isset($id) && isset($transCompanyId))
        {
            $process = Process::findOne(['id'=>$id]);

            $trans_company = TransCompany::findOne(['id'=>$transCompanyId]);

            if($trans_company == null)
            {
                $response['success'] = false;
                $response['msg'] = Yii::t("app", "Debe especificar la compañia de transporte.");
            }

            if($process && $response['success'])
            {
                $transactions = ProcessTransaction::find()->where(['process_id'=>$id])
                                                          ->andWhere(['trans_company_id'=>$trans_company->id])
                    ->orderBy('delivery_date', SORT_ASC)
                    ->all();

                $response['success'] = true;
                $response['msg'] = "Datos encontrados.";
                $response['transactions'] = [];
                $response['process'] = $process;
                $response['angecy'] = $process->agency;
                $response['containers'] = [];
                foreach ( $transactions as $t)
                {
                    $t->name_driver = utf8_encode($t->name_driver);
                    array_push($response['transactions'], $t);
                    array_push($response['containers'], $t->container);
                }
            }
            else
            {
                $response['success'] = false;
                $response['msg'] = Yii::t("app", "No fue posible encontrar los datos.");
            }
        }
        else
        {
            $response['success'] = false;
            $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
        }
        return $response;
    }

    /**
     * @param $model
     * @return array
     */
    protected function createProcess($model)
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response['success'] = false;

        if($model->load(Yii::$app->request->post()))
        {
            $transaction = Process::getDb()->beginTransaction();
            $containersByTransCompany = [];

            try {
                $aux = new DateTime($model->delivery_date, new DateTimeZone("UTC"));
                $model->delivery_date = $aux->format("Y-m-d");

                if($model->save())
                {
                    $containers = Yii::$app->request->post()["containers"];
                    $tmpResult = true;
                    foreach ($containers as $container)
                    {
                        $containerModel = Container::findOne(['name'=>$container['name']]);
                        $type = ContainerType::findOne(['id'=>$container['type']['id']]);
                        if($containerModel !== null)
                        {
                            $containerModel->code = $type->code;
                            $containerModel->tonnage = $type->tonnage;
                            $containerModel->type_id = $type->id;
                            $result = $containerModel->update();
                            if($result === false)
                            {
                                $tmpResult = false;
                                $response['msg'] = "Ah ocurrido un error al actualizar el estado del contenedor.";
                                $response['msg_dev'] = implode(", ", $containerModel->getErrorSummary(false));
                                break;
                            }
                        }
                        else
                        {
                            $containerModel = new Container();
                            $containerModel->name = $container['name'];
                            $containerModel->code = $type->code;
                            $containerModel->tonnage = $type->tonnage;
                            $containerModel->type_id = $type->id;
                            $containerModel->active = 1;

                            if(!$containerModel->save())
                            {
                                $tmpResult = false;
                                $response['msg'] = "Ah ocurrido un error al guardar los datos de los contenedores.";
                                $response['msg_dev'] = implode(", ", $containerModel->getErrorSummary(false));
                                break;
                            }
                        }
                        $transCompany = TransCompany::findOne(['ruc'=>$container['transCompany']['ruc']]);
                        if($transCompany === null) // new trans company
                        {
                            $transCompany = new TransCompany();
                            $transCompany->name = $container['transCompany']['name'];
                            $transCompany->ruc = $container['transCompany']['ruc'];
                            $transCompany->address = " ";
                            $transCompany->active = 1;

                            if(!$transCompany->save())
                            {
                                $tmpResult = false;
                                $response['msg'] = "Ah ocurrido un error al salvar los datos de las nuevas Cia de Transporte.";
                                $response['msg_dev'] = implode(" ", $transCompany->getErrorSummary(false));
                                break;
                            }
                        }

                        $processTransModelOld = ProcessTransaction::findOne(['id'=>$container['ptId']]);

                        if($processTransModelOld !== null)
                        {
                            $processTransModelOld->active = 0;
                            if(!$processTransModelOld->save())
                            {
                                $tmpResult = false;
                                $response['msg'] = "Ah ocurrido un error al actualizar los datos del proceso.";
                                $response['msg_dev'] = implode(" ", $processTransModelOld->getErrorSummary(false));
                                break;
                            }

                            // FIXME soft delete of asociated ticket
                            $ticket = Ticket::findOne(['process_transaction_id'=>$processTransModelOld->id, 'active'=>1]);
                            if($ticket)
                            {
                                $ticket->active = 0;
                                if(!$ticket->save())
                                {
                                    $tmpResult = false;
                                    $response['msg'] = "Ah ocurrido un error al actualizar los datos del proceso.";
                                    $response['msg_dev'] = implode(" ", $processTransModelOld->getErrorSummary(false));
                                    break;
                                }
                            }
                        }

                        $processTransModel = new ProcessTransaction();
                        $processTransModel->process_id = $model->id;
                        $processTransModel->container_id = $containerModel->id;
                        $processTransModel->active = 1;
                        $processTransModel->trans_company_id = $transCompany->id;
                        $processTransModel->status = 'PENDIENTE';

                        $aux = new DateTime($container['deliveryDate'], new DateTimeZone("UTC"));
//                        $aux->setTimezone(new DateTimeZone("UTC"));
                        $processTransModel->delivery_date = $aux->format("Y-m-d");

                        if(!$processTransModel->save()) {
                            $tmpResult = false;
                            $response['msg'] = "Ah ocurrido un error al salvar los datos de los contenedores.";
                            $response['msg_dev'] = implode(" ", $processTransModel->getErrorSummary(false));
                            $transaction->rollBack();
                            break;
                        }

                        if(isset($containersByTransCompany[$transCompany->id]))
                        {
                            array_push($containersByTransCompany[$transCompany->id], $containerModel);
                        }
                        else {
                            $containersByTransCompany[$transCompany->id]=[];
                            array_push($containersByTransCompany[ $transCompany->id], $containerModel);
                        }
                    }

                   try
                   {
                       if($tmpResult)
                       {
                           $response['success'] = true;
                           $remitente = AdmUser::findOne(['id'=>\Yii::$app->user->getId()]);

                           foreach($containersByTransCompany as $t=>$c) {

                               $destinatario = AdmUser::find()
                                   ->innerJoin("user_transcompany","user_transcompany.user_id = adm_user.id ")
                                   ->where(["user_transcompany.transcompany_id"=>$t])
                                   ->one();

                               if($destinatario)
                               {
//
//                                   $containers = [];
//                                   foreach ($c as $c2) {
//                                       $containers[]= $c2;
//                                   }
                                    /*
                                   //pdf create
                                   $pdf =  new mPDF( ['format'=>"A4-L"]);
                                   $pdf->SetTitle("Notificación.pdf");
                                   $pdf->WriteHTML($this->renderPartial('@app/mail/layouts/html3.php', ['model' => $model,
                                       'containers'=>$containers]));
                                   $path= $pdf->Output("","S");*/

                                   $body = Yii::$app->controller->renderPartial('notification.php', ['model' => $model,
                                       'containers'=>$c]);

//                                   $body = Yii::$app->view->renderFile('notification.php', ['model' => $model,
//                                       'containers'=>$c]);

                                   // TODO: send email user
                                   $result = Yii::$app->mailer->compose()
                                                   ->setFrom($remitente->email)
                                                   ->setTo($destinatario->email)
                                                   ->setSubject("Notificación de nuevo Proceso.")
                                                   ->setHtmlBody($body)
                                                   //->attachContent($path,[ 'fileName'=> "Nueva Solicitud de RecepciÃ³n.pdf",'contentType'=>'application/pdf'])
                                                   ->send();

                                   if($result === false)
                                   {
                                       $response['success'] = true ;
                                       $response['warning'] ="Ah ocurrido un error al enviar la notificación vía email a la empresa de transporte.";
                                   }
                               }
                           }

                           $response['msg'] = Yii::t("app", "Recepción creada correctamente.");
                           $response['url'] = Url::to(['/site/index']);

                           $transaction->commit();
                       }
                       else {
                           $transaction->rollBack();
                       }
                   }
                   catch (\PDOException $ePDO)
                   {
                       if($ePDO->getCode() !== '01000')
                       {
                           $response['success'] = false;
                           $response['msg'] = "Ah ocurrido un error al salvar los datos en el servidor.";
                           $response['msg_dev'] = $ePDO->getMessage();
                       }
                   }
                }
                else {
                    $response['success'] = false;
                    $response['msg'] =  "No fue posible crear la solicitud" ;
                }
            }
            catch (Exception $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al salvar los datos en el servidor.";
                    $response['msg_dev'] = $e->getMessage();
                    $transaction->rollBack();
                }
            }
        }
        else {
            $response['success'] = false;
            $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
        }

        return $response;
    }


    public function actionGeneratingcard()
    {

        $result = [];
        $result ["status"] = -1;
        $result ["msg"] = "";

        $user = AdmUser::findOne(["id" => Yii::$app->user->getId()]);

        $trans_company = TransCompany::find()
            ->select("trans_company.name,trans_company.id,trans_company.ruc,adm_user.email")
            ->innerJoin("user_transcompany", "user_transcompany.transcompany_id = trans_company.id")
            ->innerJoin("adm_user", "user_transcompany.user_id = adm_user.id")
            ->where(["user_transcompany.user_id" => $user->getId()])
            ->asArray()
            ->one();

        $procesos = Process::find()
            ->innerJoin("process_transaction", "process_transaction.process_id = process.id")
            ->where(['process_transaction.trans_company_id' => $trans_company["id"]])
            ->orderBy("process.bl")
            ->all();

        if ($trans_company !== null) {

            if (Yii::$app->request->post()) {
                $bl = Yii::$app->request->post("bl");
                if ($bl !== null) {

                    try {
                        $tickes = ProcessTransaction::find()
                            ->select("process_transaction.register_truck,
                                              process_transaction.register_driver,
                                              process_transaction.name_driver,
                                              process.type,
                                              process.bl,
                                              process.delivery_date,
                                              container.code,
                                              container.tonnage,
                                              trans_company.name,
                                              trans_company.ruc,
                                              ticket.id,
                                              ticket.status,
                                              calendar.start_datetime,
                                              calendar.end_datetime,
                                              warehouse.name as w_name, 
                                              agency.name as a_name")
                            ->innerJoin("process", "process_transaction.process_id = process.id ")
                            ->innerJoin("container", "container.id = process_transaction.container_id")
                            ->innerJoin("trans_company", "trans_company.id = process_transaction.trans_company_id")
                            ->innerJoin("ticket", "ticket.process_transaction_id = process_transaction.id")
                            ->innerJoin("calendar", "ticket.calendar_id = calendar.id")
                            ->innerJoin("warehouse", "warehouse.id = calendar.id_warehouse")
                            ->innerJoin("agency", "process.agency_id = agency.id")
                            ->where(["process.bl" => $bl])
                            ->andWhere(["trans_company.id" => $trans_company["id"]])
                            ->asArray()
                            ->all();

                        $paths = [];
                        $sendMail =true;

                        if(count($tickes)>0){
                            foreach ($tickes as $ticket) {

                                $aux = new DateTime($ticket["start_datetime"]);
                                $date = $aux->format("YmdHi");
                                $dateImp = date('d/m/Y H:i');
                                $info = "";
                                $info .= "EMP. TRANSPORTE: " . $trans_company["name"] . '-';
                                $info .= "TICKET NO: TI-" . $date . "-" . $ticket["id"] . '-';
                                $info .= "OPERACION: " . $ticket["type"] == Process::PROCESS_IMPORT ? "IMPORT" : "EXPOT" . '-';
                                $info .= "DEPOSITO: " . $ticket["w_name"] . '-';
                                $info .= "ECAS: " . $ticket["delivery_date"] . '-';
                                $info .= "FECHA LIMITE: " . $ticket["delivery_date"] . '-';
                                $info .= "CLIENTE: " . $ticket["a_name"] . '-';
                                $info .= "RUC/CI: " . $ticket["ruc"] . "/" . $ticket["register_driver"] . '-';
                                $info .= "CHOFER: " . $ticket["name_driver"] . '-';
                                $info .= "PLACA: " . $ticket["register_truck"] . '-';
                                $info .= "FECHA TURNO: " . substr($ticket["start_datetime"], 0, 16) . '-';
                                $info .= "CANTIDAD: 1" . '-';
                                $info .= "BOOKING: " . $ticket["bl"] . '-';
                                $info .= "TIPO CONT: " . $ticket["tonnage"] . $ticket["code"] . '-';
                                $info .= "GENERADO: " . $dateImp . '-';
                                $info .= "ESTADO: " . $ticket["status"] == 1 ? "EMITIDO" : "---";
                                $qrCode = new QrCode($info);
                                //$qrpath =  Yii::getAlias("@webroot"). "/qrcodes/".$ticket["id"]."-".date('YmdHis').".png";
                                ///sgt/web/qrcodes/3-qrcode.png
                                //$qrCode->writeFile($qrpath);
                                //$paths [] = $qrpath;
                                ob_start();
                                \QRcode::png($info, null);
                                $imageString = base64_encode(ob_get_contents());
                                ob_end_clean();



                                $bodypdf = $this->renderPartial('@app/mail/layouts/card.php',
                                                                ["trans_company" => $trans_company,
                                                                 "ticket" => $ticket,
                                                                 "qr" => "data:image/png;base64, " . $imageString,
                                                                 'dateImp' => $dateImp]);

                                $pdf = new mPDF(['mode' => 'utf-8', 'format' => 'A4-L']);
                                //$pdf->SetHTMLHeader( "<div style='font-weight: bold; text-align: center;font-family: 'Helvetica', 'Arial', sans-serif;font-size: 14px;width: 100%> Carta de Servicio </div>");
                                $pdf->WriteHTML($bodypdf);
                                $path = $pdf->Output("", "S");

                                $sendMail = $sendMail && Yii::$app->mailer->compose()
                                    ->setFrom($user->email)
                                    ->setTo($trans_company["email"])
                                    ->setSubject("Carta de Servicio")
                                    ->setHtmlBody("<h5>Se adjunta carta de servicio.</h5>")
                                    ->attachContent($path, ['fileName' => "Carta de Servicio.pdf", 'contentType' => 'application/pdf'])
                                    ->send();


                            }
                            if($sendMail) {
                                $result ["status"] = 1;
                                $result ["msg"] .= "Cartas de servicio generadas correctamente.";
                            }else{
                                $result ["status"] = 0;
                                $result ["msg"] .= "Existieron errores al enviar las cartas de servicio.";
                            }
                        }else{
                            $result ["status"] = 0;//mejorar msj
                            $result ["msg"] = "Error: No existen datos para generar cartas de servicio";
                        }


                    } catch (\Exception $ex) {
                        $result ["status"] = 0;
                        $result ["msg"] = "Error: " . $ex->getMessage();
                    }


                } else {
                    $result ["status"] = 0;
                    $result ["msg"] = "BL es requerido";
                }
            }
        } else {
            $result ["status"] = 0;
            $result ["msg"] .= "El usuario " . $user->username . " no está asociado a una compañía de transporte.";
        }

        return $this->render('generating_card', ["result" => $result, 'procesos' => $procesos]);
    }

    public function actionPrint($id){
        if(!Yii::$app->user->can("process_view")) // FIXME: change permission to process_view
            throw new ForbiddenHttpException('Usted no tiene acceso a esta recepción');

        $model = $this->findModel($id);

        $transactions = ProcessTransaction::find()
            ->innerJoin('container', 'process_transaction.container_id = container.id')
            ->innerJoin('process', 'process_transaction.process_id = process.id')
            ->where(['process.id'=>$id, 'process_transaction.active'=>1])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        $body = $this->renderPartial('print', ['model' => $model,'transactions'=>$transactions]);

        $pdf =  new mPDF(['mode'=>'utf-8' , 'format'=>'A4-L']);
        $pdf->SetTitle("Carta de Servicio");
        $pdf->WriteHTML($body);
        $path= $pdf->Output("Detalles del Proceso.pdf","D");
    }

    protected function notifyEmail($process)
    {

    }

    public function actionSgtblcons()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $deliveryDate = null;

        $bl = Yii::$app->request->get('bl');
        $processType = Yii::$app->request->get('type');

        $response = array();
        $response['success'] = true;
        $response['msg'] = '';
        $response['msg_dev'] = '';
        $response['containers'] = [];
        $response['line'] = null;
        $response['deliveryDate'] = null;

        if(!isset($bl) || !isset($processType))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el BL y el tipo de trámite de búsqueda.";
        }

        if($response['success'])
        {
            try
            {
                $sql = "exec disv..sp_sgt_bl_cons " . $bl;
                $results = Yii::$app->db->createCommand($sql)->queryAll();

                $line = null;

                if(count($results) > 0)
                {
                    $line = Line::findOne(
                        ['code'=>$results[0]['cod_linea'],
                            'oce'=>$results[0]['linea'],
                            'name'=>$results[0]['nombre_linea']]);

                    if($line === null)
                    {
                        $line = new Line();
                        $line->name = $results[0]['nombre_linea'];
                        $line->oce = $results[0]['linea'];
                        $line->code = $results[0]['cod_linea'];
                        $line->active = 1;
                        if(!$line->save())
                        {
                            $response['success'] = false;
                            $response['containers'] = [];
                            $response['msg'] = 'Ah occurrido un error al procesar los datos de la Linea Naviera.';
                        }
                    }
                    $response['line']= $line;
                    $deliveryDate = new DateTime($results[0]['fecha_limite'], new DateTimeZone("UTC"));
                }

                foreach ($results as $result)
                {
                    $data = Container::find()
                        ->select('container.id, 
                                           container.name, 
                                           process_transaction.status, 
                                           process_transaction.delivery_date as deliveryDate, 
                                           process_transaction.id as ptId, 
                                           container_type.id as typeId, 
                                           container_type.name as typeName, 
                                           container_type.code as typeCode, 
                                           container_type.tonnage as typeTonnage')
                        ->innerJoin('process_transaction', 'process_transaction.container_id=container.id')
                        ->innerJoin('process', 'process.id=process_transaction.process_id')
                        ->innerJoin('container_type', 'container_type.id=container.type_id')
                        ->where(['process.bl' => $bl])
                        ->andWhere(['process.type'=>$processType])
                        ->andWhere(['process_transaction.active'=>1])
                        ->andWhere(['container.name' => $result['contenedor']])
                        ->asArray()
                        ->one();

                    $currentDeliveryDate = new DateTime($result['fecha_limite'], new DateTimeZone("UTC"));

                    if($currentDeliveryDate > $deliveryDate)
                    {
                        $deliveryDate = $currentDeliveryDate;
                    }

                    $container = null;

                    if ($data === null) {
                        $container = [];
                        $container['id'] = -1;
                        $container['name'] = $result['contenedor'];
                        $container['ptId'] = -1;
                        $container['type'] = ["id"=>-1,"name"=>""];
                        $container['status'] = '';

                    }
                    else
                    {
                        $container = [];
                        $container['id'] = $data['id'];
                        $container['name'] = $data['name'];
                        $container['ptId'] =  $data['ptId'];
                        $container['type'] = new  ContainerType();
                        $container['type']->id = $data['typeId'];
                        $container['type']->name = $data['typeName'];
                        $container['type']->code = $data['typeCode'];
                        $container['type']->tonnage = $data['typeTonnage'];
                        $container['status'] = $data['status'];
                    }
                    $container['deliveryDate'] = $result['fecha_limite'];
                    $container['errCode'] = $result['err_code'];
                    $response['containers'][] = $container;
                }

                $response['deliveryDate'] = $deliveryDate->format("Y-m-d H:i:s");
            }
            catch (Exception $ex)
            {
                $response['success'] = false;
                $response['msg'] = 'Ah occurrido un error al buscar los contenedores.';
                $response['msg_dev'] = $ex->getMessage();
            }
        }
        return $response;
    }

    public function actionSgtbookingcons()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $booking = Yii::$app->request->get('bl');
        $processType = Yii::$app->request->get('type');

        $response = array();
        $response['success'] = true;
        $response['msg'] = '';
        $response['msg_dev'] = '';
        $response['containers'] = [];
        $response['line'] = null;
        $response['deliveryDate'] = null;

        $deliveryDate = null;

        if(!isset($booking) || !isset($processType))
        {
            $response['success'] = false;
            $response['msg'] = "Debe especificar el Booking y el tipo de trámite de búsqueda.";
        }

        if($response['success'])
        {
            try
            {
                $sql = "exec disv..sp_sgt_booking_cons " . $booking;
                $results = Yii::$app->db->createCommand($sql)->queryAll();

                $line = null;

                if(count($results) > 0)
                {
                    $line = Line::findOne(
                        ['code'=>$results[0]['cod_linea'],
                            'oce'=>$results[0]['linea'],
                            'name'=>$results[0]['nombre_linea']]);

                    if($line === null)
                    {
                        $line = new Line();
                        $line->name = $results[0]['nombre_linea'];
                        $line->oce = $results[0]['linea'];
                        $line->code = $results[0]['cod_linea'];
                        $line->active = 1;
                        if(!$line->save())
                        {
                            $response['success'] = false;
                            $response['containers'] = [];
                            $response['msg'] = 'Ah occurrido un error al procesar los datos de la Linea Naviera.';
                        }
                    }
                    $response['line']= $line;

                    $deliveryDate = new DateTime($results[0]['fecha_limite'], new DateTimeZone("UTC"));
                }

                foreach ($results as $result)
                {
                    $type = ContainerType::findOne(['code'=>$result['tipo'], 'tonnage'=>(int)$result['tamanio']]);

                    if($type === null)
                    {
                        $type = new ContainerType();
                        $type->code = $result['tipo'];
                        $type->tonnage = (int)$result['tamanio'];
                        $type->name = $type->code . $type->tonnage;
                        $type->active = 1;
                        if(!$type->save())
                        {
                            $response['success'] = false;
                            $response['containers'] = [];
                            $response['msg'] = 'Ah occurrido un error al procesar los grupos de contenedores.';
                            break;
                        }
                    }

                    $currentDeliveryDate = new DateTime($result['fecha_limite'], new DateTimeZone("UTC"));
                    if($currentDeliveryDate > $deliveryDate)
                    {
                        $deliveryDate = $currentDeliveryDate;
                    }

                    $count = (int)$result['cantidad'];

                    for($i = 0; $i < $count; $i++)
                    {
                        $containerName = $booking . $type->code . $type->tonnage . '-' . ($i + 1);

                        $data = Container::find()
                            ->select('container.id, 
                                           container.name, 
                                           process_transaction.status, 
                                           process_transaction.delivery_date as deliveryDate, 
                                           process_transaction.id as ptId, 
                                           container_type.id as typeId, 
                                           container_type.name as typeName, 
                                           container_type.code as typeCode, 
                                           container_type.tonnage as typeTonnage')
                            ->innerJoin('process_transaction', 'process_transaction.container_id=container.id')
                            ->innerJoin('process', 'process.id=process_transaction.process_id')
                            ->innerJoin('container_type', 'container_type.id=container.type_id')
                            ->where(['process.bl' => $booking])
                            ->andWhere(['process.type'=>$processType])
                            ->andWhere(['process_transaction.active'=>1])
                            ->andWhere(['container.name' => $containerName])
                            ->asArray()
                            ->one();

                        $currentDeliveryDate = new DateTime($results['fecha_limite'], new DateTimeZone("UTC"));

                        if($currentDeliveryDate > $deliveryDate)
                        {
                            $deliveryDate = $currentDeliveryDate;
                        }

                        $container = null;

                        if ($data === null) {
                            $container = [];
                            $container['id'] = -1;
                            $container['name'] = $containerName;
                            $container['ptId'] = -1;
                            $container['type'] = $type;
                            $container['status'] = '';

                        }
                        else
                        {
                            $container = [];
                            $container['id'] = $data['id'];
                            $container['name'] = $data['name'];
                            $container['ptId'] =  $data['ptId'];
                            $container['type'] = new  ContainerType();
                            $container['type']->id = $data['typeId'];
                            $container['type']->name = $data['typeName'];
                            $container['type']->code = $data['typeCode'];
                            $container['type']->tonnage = $data['typeTonnage'];
                            $container['status'] = $data['status'];
                        }

                        $container['deliveryDate'] = $result['fecha_limite'];
                        $container['errCode'] = $result['err_code'];
                        $response['containers'][] = $container;
                    }
                }

                $response['deliveryDate'] = $deliveryDate->format("d-m-Y H:i:s");
            }
            catch (Exception $ex)
            {
                $response['success'] = false;
                $response['msg'] = 'Ah occurrido un error al buscar los contenedores.';
                $response['msg_dev'] = $ex->getMessage();
            }
        }
        return $response;
    }
}
