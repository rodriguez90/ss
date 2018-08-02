<?php

namespace app\modules\rd\controllers;

use DateTime;
use DateTimeZone;
use app\modules\rd\models\Process;
use yii\db\Exception;
use yii\filters\AccessControl;
use app\modules\rd\models\TransCompany;
use Yii;
use app\modules\rd\models\Ticket;
use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\TicketSearch;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ProcessTransaction;
use app\modules\rd\models\Container;
use app\modules\rd\models\Calendar;
use yii\db\Transaction;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use Da\QrCode\QrCode;
use Mpdf\Mpdf;
/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
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
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->can("ticket_view"))
            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos.');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        if(!Yii::$app->user->can("ticket_create"))
            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos.');

        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);

        $model = Process::findOne(['id'=>$id]);

//        if($user && !($user->hasRol('Cia_transporte')))
//            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos en la recepción');

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }


    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->user->can("ticket_delete"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->delete($id);
    }

    public function actionReserve()
    {
        if(!Yii::$app->user->can("ticket_update"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $tickets = Yii::$app->request->post('tickets');
        $process = Yii::$app->request->post('reception');
        return $this->doTicket($tickets, $process, Ticket::RESERVE);
    }

    public function actionPrebooking()
    {
        if(!Yii::$app->user->can('ticket_update'))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $tickets = Yii::$app->request->post('tickets');
        $reception = Yii::$app->request->post('reception');
        return $this->doTicket($tickets, $reception, Ticket::PRE_BOOKING);
    }

    public function actionByProcess()
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response['success'] = false;
        $response['msg'] = '';
        $response['tickets'] = [];

        $processId = Yii::$app->request->get('processId');


        if(isset($processId))
        {
            $tickets = Ticket::find()->innerJoin('process_transaction', 'process_transaction_id=process_transaction.id')
                ->innerJoin('calendar', 'calendar_id=calendar.id')
                ->where(['process_transaction.process_id'=>$processId])
                ->andWhere(['ticket.active'=>1])
                ->orderBy(['calendar.start_datetime'=>SORT_ASC])
                ->all();
            $response['tickets'] = $tickets;
            $response['success'] = true;
        }
        else{
            $response['msg'] = 'Bad request';
        }

        return $response;
    }

    protected function generateServiceCardByTicket($cardsServiceData)
    {
        $user = Yii::$app->user->identity;

        $trans_company = $user->getTransCompany();		
        $result = true;

        if($trans_company !== null)
        {
            try{

                $pdf = new mPDF(['mode' => 'utf-8', 'format' => 'A4-L']);

                foreach ($cardsServiceData as $ticket)
                {
                    if($ticket !== null)
                    {
                        $aux = new DateTime( $ticket["start_datetime"] );
                        $date = $aux->format("YmdHi");
                        $ticket["start_datetime"] = $aux->format("d-m-Y H:i");
                        $dateImp = new DateTime($ticket["created_at"]);
                        $dateImp = $dateImp->format('d-m-Y H:i');

                        $info .= "EMP. TRANSPORTE: " . $trans_company["name"] . ' ';
                        $info .= "TICKET NO: TI-" . $date . "-" . $ticket["id"] . ' ';
                        $info .= "OPERACIÓN: " . $ticket["type"] == Process::PROCESS_IMPORT ? "IMPORTACIÓN":"EXPORTACIÓN" . '  ';
                        $info .= "DEPÓSITO: " . $ticket["w_name"] . ' ';
                        $info .= "ECAS: " . $ticket["delivery_date"] . ' ';
                        $info .= "CLIENTE: " . $ticket["a_name"] . ' ';
                        $info .= "CHOFER: " . $ticket["name_driver"] . "/" . $ticket["register_driver"] . ' ';
                        $info .= "PLACA: " . $ticket["register_truck"] . ' ';
                        $info .= "FECHA TURNO: " . $ticket["start_datetime"] . ' ';
                        $info .= "CANTIDAD: 1" . ' ';
                        $info .= ($ticket["type"] == Process::PROCESS_IMPORT ? "BL":"BOOKING") . ": ". $ticket["bl"] . ' ';
                        $info .= "TIPO CONT: " . $ticket["tonnage"] . $ticket["code"] . ' ';
                        $info .= "GENERADO: " . $dateImp . ' ';
                        $info .= "ESTADO: " . $ticket["status"] == 1 ? "EMITIDO" : "---";

                        $qrCode = new QrCode($info);

                        ob_start();
                        \QRcode::png($info,null);
                        $imageString = base64_encode(ob_get_contents());
                        ob_end_clean();

                        $bodypdf = $this->renderPartial('@app/mail/layouts/card.php',
                            ['trans_company'=> $trans_company,
                                'ticket'=>$ticket,
                                'qr'=>"data:image/png;base64, ".$imageString,
                                'dateImp'=>$dateImp,
                                'date'=>$date]);

                        $pdf->AddPage();
                        $pdf->WriteHTML($bodypdf);
                    }
                }

                $attach = $pdf->Output("", "S");
                $email = Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail']) // FIXME: Create Email Account
                    ->setTo($user->email)
                    ->setBcc(Yii::$app->params['adminEmail'])
                    ->setSubject("Carta de Servicio")
                    ->setHtmlBody("<h5>Se adjunta carta de servicio.</h5>")
                    ->attachContent($attach, ['fileName' => "Carta de Servicio.pdf", 'contentType' => 'application/pdf']);

                $result = $email->send();


            }catch (\Exception $ex){
                $result = false;
            }
        }
        return $result;
    }
	
	public function actionMyCalendar()
    {
        if(!(Yii::$app->user->can('ticket_create') ||  Yii::$app->user->can("calendar_create")))
            throw new ForbiddenHttpException('Usted no tiene permiso a esta página');

        $user = Yii::$app->user->identity; // AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

        return $this->render('shedule', [
            'user' =>$user,
        ]);
    }

    public function actionShedule()
    {
        $response = array();

        $response['msg'] = '';
        $response['msg_dev'] = '';
        $response['success'] = true;
        $response['tickets'] = [];

        if(!(Yii::$app->user->can('ticket_create') ||  Yii::$app->user->can("calendar_list")))
        {
            $response['sucess'] = false;
            $response['msg'] = 'Usted no tiene permiso a esta página';
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

        $transCompany = $user->getTransCompany();

        $tickets = [];
        $results = Ticket::find()
            ->select('ticket.id, 
                                        ticket.calendar_id, 
                                        ticket.status, 
                                        calendar.start_datetime, 
                                        calendar.end_datetime, 
                                        process_transaction.container_id,
                                        process_transaction.register_truck,
                                        process_transaction.register_driver,
                                        process_transaction.name_driver,
                                        container.name,
                                        container.code,
                                        container.tonnage')
            ->innerJoin('process_transaction', 'process_transaction.id=ticket.process_transaction_id')
            ->innerJoin('calendar', 'calendar.id=ticket.calendar_id')
            ->innerJoin('container', 'container.id=process_transaction.container_id')
            ->where(['ticket.active'=>1])
            ->andFilterWhere(['process_transaction.trans_company_id'=>$transCompany->id])
            ->orderBy(['calendar.start_datetime'=>SORT_ASC])
            ->asArray()
            ->all();

        foreach ($results as $result)
        {
            $result['name_driver'] = utf8_encode($result['name_driver']);
            $tickets [] = $result;
        }
        $response['tickets'] = $tickets;

        return $response;
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id'=>$id, 'active'=>1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitda no existe.');
    }

     private function delete($id)
    {
        $model = Ticket::findOne(['id'=>$id]);
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $response['success'] = true;

        if($model)
        {
            $response['ticket'] = $model;
            $transaction = Ticket::getDb()->beginTransaction();

            try {

                $model->active = -1;
                if($model->save())
                {
                    $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);
                    $calendarSlot->amount++;
                    $result = $calendarSlot->update();
                    if($result === false)
                    {
                        $response['success'] = false;
                        $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario.';
                        $response['msg_dev'] = implode(" ", $calendarSlot->getErrorSummary(false));
                    }

                    if($response['success'])
                    {
                        $processTransaction = ProcessTransaction::findOne(['id'=>$model->process_transaction_id]);

                        if($processTransaction)
                        {
                            $processTransaction->register_driver = '';
                            $processTransaction->register_truck = '';
                            $processTransaction->name_driver = '';
                            $processTransaction->status = 'PENDIENTE';

                            if(!$processTransaction->save())
                            {
                                $response['success'] = false;
                                $response['msg'] = 'Ah ocurrido un error al actualizar los datos de transportación.';
                                $response['msg_dev'] = implode(" ", $model->getErrorSummary(false));
                            }
                        }
                    }
                }
                else
                {
                    $response['success'] = false;
                    $response['msg'] = 'Ah ocurrido un error al eliminar el turno.';
                    $response['msg_dev'] = implode(" ", $model->getErrorSummary(false));
                }

                if($response['success'] == true)
                {
                    $transaction->commit();
                }
                else {
                    $transaction->rollBack();
                }
            }
            catch (\PDOException $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = 'Ah ocurrido un error inesperado en el servidor.';
                    $response['msg_dev'] = $e->getMessage();
                    $transaction->rollBack();
                }
            }

            if($response['success'] && $model->acc_id)
            {
                $result = $this->notifyDeletedTickets([$model], $user->username);

                if($result['success'] === false) // notification error
                {
                    $response['success'] = false;
                    $response['msg'] = $result['msg'];
                    $response['msg_dev'] = $result['msg_dev'];
                }
            }
        }
        else {
            $response['success'] = false;
            $response['msg'] = 'El turno no existe';
            $response['msg_dev'] = '';
        }

        return $response;
    }
    
	 private function doTicket($tickets, $reception, $status)
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response['success'] = true;
        $response['msg'] = '';
        $response['warning'] = '';
        $response['msg_dev'] = '';
        $customMsg = '';

        if($status === Ticket::PRE_BOOKING)
            $customMsg = 'pre-reserva';
        elseif ($status === Ticket::RESERVE)
            $customMsg = 'reserva';

        $processModel = Process::findOne(['id'=>$reception['id']]);
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

        // TPG NOTTFIE
        $processType = $processModel->type == 1 ? 'IMPO':'EXPO';

        $userName = '';
        if($user)
        {
            $userName = $user->username;
        }

//        $transaction = Process::getDb()->beginTransaction();

        $newTickets = [];
        $calendarsMod = [];
        $ptMod = [];
        $cardsServiceData = [];
        $calendarToSave = [];
        $ptToSave = [];
        $calendarsAmount = [];
        $transportationDataToValidate = [];

        $processStatus = true;

        try {

            // validating transportation data
//            foreach ($tickets as $data)
//            {
//                $transData = $transportationDataToValidate[$data['calendar_id']];
//                if(!$transData)
//                    $transportationDataToValidate[$data['calendar_id']] = ['registerTruck'=>[],
//                    'registerDriver'=>[]];
//
//                $transData['registerTruck'][] = $data['registerTruck'];
//                $transData['registerDriver'][] = $data['registerDriver'];
//
//                $transportationDataToValidate[$data['calendar_id']] = $transData;
//            }
//
//            foreach ($transportationDataToValidate as $calendar=>$transData)
//            {
//                $result = ProcessTransaction::find()
//                    ->innerJoin('ticket', 'ticket.process_transaction_id=process_transaction.id')
//                    ->innerJoin('calendar', 'calendar.id=ticket.calendar_id')
//                    ->where(['calendar.id'=>$calendar])
//                    ->andWhere(['or',
//                        'process_transaction.register_truck'=>$transData['registerTruck'],
//                        'process_transaction.register_driver'=>$transData['registerDriver']])
//                    ->count();
//
//                if($result > 0)
//                {
//                    $processStatus = false;
//                    $response['msg'] = 'No fue posible crear los turnos, porque ya hay placas o choferes sociados en la fecha reservada';
//                    break;
//                }
//            }

            if($processStatus)
            {
                foreach ($tickets as $data)
                {
                    $model = new Ticket();
                    $model->process_transaction_id = $data['process_transaction_id'];
                    $model->calendar_id = $data['calendar_id'];
                    $model->active = $data['active'];
                    $model->status = $data['status'];
                    $model->acc_id = 0;

                    $calendarSlot = Calendar::findOne(['id' => $model->calendar_id]);

                    if ($calendarSlot === null) {
                        $processStatus = false;
                        $response['msg'] = 'No fue posible encontrar el calendario.';
                        break;
                    }

                    $processStatus = $calendarSlot->amount > 0; // Check disponibility in calendar

                    if (!$processStatus) {
                        $processStatus = false;
                        $response['msg'] = 'No hay disponibilidad en el calendario';
                        break;
                    }

                    if ($model->validate()) // validate model
                    {
                        if ($processStatus)
                        {
                            $model->status = $status;
                            $processStatus = $model->save();
                            if (!$processStatus) {
                                $processStatus = false;
                                $response['msg'] = 'Ah ocurrido un error al crear el turno.';
                                $response['msg_dev'] = implode(" ", $model->getErrorSummary(false));
                                break;
                            }

                            if ($calendarToSave[$calendarSlot->id] == null) {
                                $calendarToSave[$calendarSlot->id] = $calendarSlot;
                                $calendarsAmount[$calendarSlot->id] = $calendarSlot->amount;
                            }

                            $calendarToSave[$calendarSlot->id]->amount = $calendarToSave[$calendarSlot->id]->amount - 1;
//
//                        $calendarSlot->amount--;
//                        $result = $calendarSlot->update();
//                        if ($result === false) {
//                            $processStatus = false;
//                            $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: ' .
//                                implode(" ", $calendarSlot->getErrorSummary(false));
//                            break;
//                        }
                        }

                        if ($processStatus)
                        {

                            $processTransaction = ProcessTransaction::findOne(['id' => $model->process_transaction_id]);
                            $processTransaction->register_truck = $data['registerTruck'];
                            $processTransaction->register_driver = $data['registerDriver'];
                            $processTransaction->name_driver = $data['nameDriver'];
                            $dateStatus = new DateTime($calendarSlot->start_datetime, new DateTimeZone('UTC'));
                            $processTransaction->status = $dateStatus->format("Y-m-d H:i:s");
                            $ptToSave[] = $processTransaction;
//                        $result = $processTransaction->update(true, ['register_truck', 'register_driver', 'name_driver']);
//                        if ($result === false) {
//                            $processStatus = false;
//                            $response['msg'] = 'Ah ocurrido un error al actualizar la placa del camión y los datos del chofer: ' .
//                                implode(" ", $processTransaction->getErrorSummary(false));
//                            break;
//                        }
                        }

                        if ($processStatus) {
                            $newTickets[] = $model;
                            $cardsServiceData [] = [
                                'register_truck'=>$data['registerTruck'],
                                'register_driver'=>$data['registerDriver'],
                                'name_driver'=>$data['nameDriver'],
                                'type'=>$processModel->type,
                                'bl'=>$processModel->bl,
                                'delivery_date'=>$processModel->delivery_date,
                                'code'=>$processTransaction->container->code,
                                'tonnage'=>$processTransaction->container->tonnage,
                                'name'=>$processTransaction->transCompany->name,
                                'ruc'=>$processTransaction->transCompany->ruc,
                                'id'=>$model->id,
                                'status'=>$model->status,
                                'created_at'=>$model->created_at,
                                'start_datetime'=>$calendarSlot->start_datetime,
                                'end_datetime'=>$calendarSlot->end_datetime,
                                'w_name'=>$calendarSlot->warehouse->name,
                                'a_name'=>$processModel->agency->name,
                            ];

                        }
                    } else {
                        $processStatus = false;
                        $response['msg'] = Yii::t("app", "Los datos enviados al servidor son invalidos.");
                    }
                }
            }

            if($processStatus)
            {
                foreach ($calendarToSave as $c) {
                    if ($c->save() === false) {
                        $processStatus = false;
                        $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario.';
                        $response['msg_dev'] = implode(" ", $calendarSlot->getErrorSummary(false));
                        break;
                    }
                    $calendarsMod[] = $c;
                }
            }

            if($processStatus)
            {
                foreach ($ptToSave as $pt) {

                    if ($pt->save() === false) {
                        $processStatus = false;
                        $response['msg'] = 'Ah ocurrido un error al actualizar los datos del ticket';
                        $response['msg_dev'] = implode(' ', $pt->getErrorSummary(false));
                        break;
                    }
                    $ptMod[] = $pt;
                }
            }

            if($processStatus)
            {
                if($this->generateServiceCardByTicket($cardsServiceData) === false)
                {
                    $response['warning'] = 'Error al generar y enviar las cartas de servicio.';
                }


                $response['success'] = true;
                $response['msg'] = 'Reservas Realizada';
                $response['url'] = Url::to(['/site/index']);
            }

            if(!$processStatus) // manual rollback
            {
                foreach ($newTickets as $t)
                {
                    $t->delete();
                }

                foreach ($calendarsMod as $c)
                {
                    $c->amount = $calendarsAmount[$c->id];
                    $c->save();
                }

                foreach ($ptMod as $pt)
                {
                    $pt->register_truck = '';
                    $pt->register_driver = '';
                    $pt->name_driver = '';
                    $pt->status = 'PENDIENTE';
                    $pt->save();
                }
            }

//            if($processStatus) // update process status
//            {
//                $countTicketForProcess = TicketSearch::find()->innerJoin('process_transaction', 'ticket.process_transaction_id = process_transaction.id')
//                    ->innerJoin('process', 'process.id=process_transaction.process_id')
//                    ->where(['process.id'=>$processModel->id])->count();
//
//                $countProcessTransaction = ProcessTransaction::find()->where(['process_id'=>$processModel->id])->count();
//
//                if($processModel !== null)
//                {
//                    if($countTicketForProcess === $countProcessTransaction)
//                        $processModel->active =  0;
//                    else
//                        $processModel->active =  1;
//                    $result = $processModel->update();
//                    if($result === false)
//                    {
//                        $processStatus = false;
//                        $response['msg'] = 'Ah ocurrido un error al actualizar el estado de la recepción: ' .
//                            implode(" ", $processModel->getErrorSummary(false));
//                    }z
//                }
//                else {
//                    $processStatus = false;
//                    $response['msg'] = 'Ah ocurrido un error el proceso no es valido';
//                }
//            }
        }
        catch (\PDOException $e)
        {
            if($e->getCode() !== '01000')
            {
                $processStatus = false;
                $response['success'] = false;
                $response['msg'] = 'Ah ocurrido un error al generar los ticket.';
            }
        }


        if($processStatus)
        {
           $result = $this->notifyNewTickets($processType, $processModel->bl, $userName, $newTickets);
            if(!$result['success'])
            {
                $response['warning'] = $result['msg'];
                $response['msg_dev'] = $result['msg_dev'];
            }

        }
        return $response;
    }
	
	protected function notifyNewTickets($processType,
                                        $bl,
                                        $user,
                                        $tickets)
    {
        $response = [];
        $response['success'] = true;
        $response['msg'] = '';
        $response['msg_dev'] = '';

        try
        {
            $sql = "exec  disv..sp_sgt_access_ins '";

            foreach ($tickets as $ticket)
            {
                $calendarSlot = $ticket->calendar;
                $processTransaction = $ticket->processTransaction;
                $dateTicket = '';

                if($calendarSlot === null ||
                    $processTransaction === null)
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al notificar los nuevos turnos al TPG.";
                    break;
                }

                $container = $processTransaction->container;

                if($container === null)
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al notificar los nuevos turnos al TPG.";
                    break;
                }

                $aux = new \DateTime($calendarSlot->start_datetime);
                $dateTicket = $aux->format("Ymd H:i");

                $registerTrunk = $processTransaction->register_truck;
                $registerDriver = $processTransaction->register_driver;
                $containerName = $container->name;

                $sql_complete = $sql . $processType . "','".
                                $registerTrunk . "','" .
                                $registerDriver . "','" .
                                $containerName . "','" .
                                $dateTicket . "','" .
                                $user . "','" .
                                $bl . "'";

                $result = \Yii::$app->db3->createCommand($sql_complete)->queryAll();

                if($result['err_code'] == "1")
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al notificar los nuevos turnos.";
                    $response['msg_dev'] = $result['err_msg'];
                    break;
                }
                else {

                    $ticket->acc_id = $result[0]['acc_id'];
                    if($ticket->update(true, ['acc_id']) == false)
                    {
                        $response['success'] = false;
                        $response['msg'] = "Ah ocurrido un error al actualizar el acceso del turno al TPG.";
                        $response['msg_dev'] = implode(' ', $ticket->getErrorSummary(false));
                        break;
                    }
                }
            }
        }
        catch (Exception $exception)
        {
            $response['success'] = false;
            $response['msg'] = "Ah ocurrido un error al notificar los nuevos turnos al TPG";
            $response['msg_dev'] = $exception->getMessage();
        }

        return $response;
    }

    protected function notifyDeletedTickets($tickets, $user)
    {

        $response = [];
        $response['success'] = true;
        $response['tickets'] = [];

        try
        {
//            exec disv..sp_sgt_access_elimina 7316061, 'test'
            $sql = "exec  disv..sp_sgt_access_elimina ";

            foreach ($tickets as $ticket)
            {
                if($ticket->acc_id)
                {
                    $sqlCompleted = $sql . $ticket->acc_id . ",'" . $user . "'";

                    $result = \Yii::$app->db3->createCommand($sqlCompleted)->queryAll();

                    if($result['err_code'] == 1)
                    {
                        $response['success'] = false;
                        $response['msg'] = "Ah ocurrido un error al notificar al TPG la eliminación de los turnos.";
                        $response['msg_dev'] = $result['err_msg'];
                        break;
                    }                   

                    $response['tickets'][]=$ticket;
                }
            }
        }
        catch (Exception $exception)
        {
            $response['success'] = false;
            $response['msg'] = "Ah ocurrido un error al notificar al TPG la eliminación de los turnos.";
            $response['msg_dev'] = $exception->getMessage();
        }

        return $response;
    }

}
