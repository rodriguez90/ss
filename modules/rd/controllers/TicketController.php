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
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

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
        $reception = Yii::$app->request->post('reception');
        return $this->doTicket($tickets, $reception, Ticket::RESERVE);
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
        $response['msg'] = 'Unknow';
        $response['tickets'] = [];

        $processId = Yii::$app->request->get('processId');


        if(isset($processId))
        {
            $tickets = Ticket::find()->innerJoin('process_transaction', 'process_transaction_id=process_transaction.id')
                ->innerJoin('calendar', 'calendar_id=calendar.id')
                ->where(['process_transaction.process_id'=>$processId])
                ->all();
            $response['tickets'] = $tickets;
            $response['success'] = true;
        }
        else{
            $response['msg'] = 'Bad request';
        }

//        var_dump($response);die;

        return $response;
    }

    protected function generateServiceCardByTicket($id)
    {
        $user = AdmUser::findOne(["id"=>Yii::$app->user->getId()]);

        $trans_company = TransCompany::find()
            ->select("trans_company.name,trans_company.id,trans_company.ruc,adm_user.email")
            ->innerJoin("user_transcompany","user_transcompany.transcompany_id = trans_company.id")
            ->innerJoin("adm_user","user_transcompany.user_id = adm_user.id")
            ->where(["user_transcompany.user_id"=>$user->getId()])
            ->asArray()
            ->one();

        if($trans_company !== null){
            try{
                $ticket = ProcessTransaction::find()
                    ->select("process_transaction.register_truck,process_transaction.register_driver,process_transaction.name_driver,process.type,process.bl,process.delivery_date,container.code,container.tonnage,trans_company.name,trans_company.ruc,ticket.id,ticket.status,calendar.start_datetime,calendar.end_datetime,warehouse.name as w_name, agency.name as a_name")
                    ->innerJoin("process","process_transaction.process_id = process.id ")
                    ->innerJoin("container", "container.id = process_transaction.container_id")
                    ->innerJoin("trans_company", "trans_company.id = process_transaction.trans_company_id")
                    ->innerJoin("ticket", "ticket.process_transaction_id = process_transaction.id")
                    ->innerJoin("calendar", "ticket.calendar_id = calendar.id")
                    ->innerJoin("warehouse", "warehouse.id = calendar.id_warehouse")
                    ->innerJoin("agency", "process.agency_id = agency.id")
                    ->where(["ticket.id"=>$id])
                    ->asArray()
                    ->one();

                if($ticket !== null)
                {
                    $aux = new DateTime( $ticket["start_datetime"] );
                    $date = $aux->format("YmdHi");
                    $dateImp = date('d/m/Y H:i');

                    $info.= $trans_company["name"]. '  ';
                    $info.= "TI-" . $date . "-".$ticket["id"]. '  ';
                    $info.= $ticket["type"] == Process::PROCESS_IMPORT ? "IMPORT":"EXPOT" . '  ';
                    $info.= $ticket["w_name"]. '  ';
                    $info.= $ticket["delivery_date"]. '  ';
                    $info.= $ticket["a_name"]. '  ';
                    $info.= $ticket["name_driver"]. '  ';
                    $info.= $ticket["register_truck"]. '  ';
                    $info.= substr($ticket["start_datetime"],0,16). '  ';
                    $info.= $ticket["bl"]. '  ';
                    $info.= $ticket["tonnage"] .$ticket["code"]. '  ';
                    $info.= $dateImp . '  ';
                    $info.= $ticket["status"] == 1 ? "EMITIDO":"---". '  ';
                    $qrCode = new QrCode($info);

                    ob_start();
                    \QRcode::png($info,null);
                    $imageString = base64_encode(ob_get_contents());
                    ob_end_clean();

                    $bodypdf = $this->renderPartial('@app/mail/layouts/card.php', ["trans_company"=> $trans_company, "ticket"=>$ticket,"qr"=>"data:image/png;base64, ".$imageString, 'dateImp'=>$dateImp]);
                    ini_set('max_execution_time', '5000');
                    $pdf =  new mPDF(['mode'=>'utf-8' , 'format'=>'A4-L']);
                    $pdf->SetTitle("Carta de Servicio");
                    $pdf->WriteHTML($bodypdf);
                    $path= $pdf->Output("","S");

                    $result = Yii::$app->mailer->compose()
                                                ->setFrom($user->email)
                                                ->setTo($trans_company["email"])
                                                ->setSubject("Carta de Servicio")
                                                ->setHtmlBody("<h5>Se adjunta carta de servicio.</h5>")
                                                ->attachContent($path,[ 'fileName'=> "Carta de Servicio.pdf",'contentType'=>'application/pdf'])
                                                ->send();

                    return $result;
                }
            }catch (\Exception $ex){
                var_dump($ex->getMessage());//die;
                return false;
            }
        }
    }

    public function actionMyCalendar()
    {
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

        return $this->render('shedule', [
            'user' =>$user,
        ]);
    }

    public function actionShedule()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

        $transCompany = $user->getTransCompany();

        $response = array();

        $response['msg'] = '';
        $response['msg_dev'] = '';
        $response['sucess'] = true;


        if($transCompany)
        {
            $tickets = Ticket::find()
                ->select('ticket.id, 
                                ticket.calendar_id, 
                                ticket.status, 
                                calendar.start_datetime, 
                                calendar.end_datetime, 
                                process_transaction.container_id,
                                container.name,
                                container.code,
                                container.tonnage')
                ->innerJoin('process_transaction', 'process_transaction.id=ticket.process_transaction_id')
                ->innerJoin('calendar', 'calendar.id=ticket.calendar_id')
                ->innerJoin('container', 'container.id=process_transaction.container_id')
                ->where(['process_transaction.trans_company_id'=>$transCompany->id])
                ->andWhere(['ticket.active'=>1])
                ->asArray()
                ->all();
            $response['tickets'] = $tickets;
            $response['success'] = true;
        }


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
        if (($model = Ticket::findOne($id)) !== null) {
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
            $transaction = Ticket::getDb()->beginTransaction();

            try {

                if($response['success'])
                {
                    if($model->delete())
                    {
                        $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);
                        $calendarSlot->amount++;
                        $result = $calendarSlot->update();
                        if($result === false)
                        {
                            $response['success'] = false;
                            $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario.';
                            $response['msg_dev'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: '.
                                implode(" ", $calendarSlot->getErrorSummary(false));
                        }

                        if($response['success'])
                        {
                            $processTransaction = ProcessTransaction::findOne(['id'=>$model->process_transaction_id]);

                            if($processTransaction)
                            {
                                $processTransaction->register_driver = '';
                                $processTransaction->register_truck = '';
                                $processTransaction->name_driver = '';
                            }
                        }
                    }
                    else
                    {
                        $response['success'] = false;
                        $response['msg'] = 'Ah ocurrido un error al eliminar el ticket.'.
                            $response['msg_dev'] = 'Ah ocurrido un error al eliminar el ticket: '.
                                implode(" ", $model->getErrorSummary(false));
                    }
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
                $result = $this->notifyDeletedTickets([$model], $user->nombre);

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
        $response['msg'] = 'Unknow';
        $customMsg = '';

        if($status === Ticket::PRE_BOOKING)
            $customMsg = 'pre-reserva';
        elseif ($status === Ticket::RESERVE)
            $customMsg = 'reserva';

        $transaction = Process::getDb()->beginTransaction();

        $processModel = Process::findOne(['id'=>$reception['id']]);
        $newTickets = [];

        // TPG NOTTFIE
        $processType = $processModel->type === Process::PROCESS_IMPORT ? 'IMPO':'EXPO';
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);
        $userName = '';
        if($user)
        {
            $userName = $user->nombre;
        }

        try {
            $processStatus = true;

            $ticketIds = [];

            foreach ($tickets as $data)
            {
                $model = new Ticket();
                $model->process_transaction_id = $data['process_transaction_id'];
                $model->calendar_id = $data['calendar_id'];
                $model->active = $data['active'];
                $model->status = $data['status'];
                $model->acc_id = 0;

                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);

                if($calendarSlot === null)
                {
                    $processStatus = false;
                    $response['msg'] = 'No fue posible encontrar el calendario.';
                    break;
                }

                $processStatus = $calendarSlot->amount > 0; // Check disponibility in calendar

                if(!$processStatus)
                {
                    $processStatus = false;
                    $response['msg'] = 'No hay disponibilidad en el calendario';
                    break;
                }

                if($model->validate()) // validate model
                {

                    if ($processStatus) {
                        $model->status = $status;
                        $processStatus = $model->save();
                        if (!$processStatus) {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al crear el cupo.';
                            $response['msg_dev'] = 'Ah ocurrido un error al crear el cupo' .
                                implode(" ", $model->getErrorSummary(false));
                            break;
                        }
                        $ticketIds [] = $model->id;

                        $calendarSlot->amount--;
                        $result = $calendarSlot->update();
                        if ($result === false) {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: ' .
                                implode(" ", $calendarSlot->getErrorSummary(false));
                            break;
                        }
                    }

                    if ($processStatus) {
                        $processTransaction = ProcessTransaction::findOne(['id' => $model->process_transaction_id]);
                        $processTransaction->register_truck = $data['registerTruck'];
                        $processTransaction->register_driver = $data['registerDriver'];
                        $processTransaction->name_driver = $data['nameDriver'];
                        $result = $processTransaction->update(true, ['register_truck', 'register_driver', 'name_driver']);
                        if ($result === false) {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al actualizar la placa del camión y los datos del chofer: ' .
                                implode(" ", $processTransaction->getErrorSummary(false));
                            break;
                        }
                    }

                    if($processStatus)
                    {
                        $newTickets[] = $model;
                    }
                }
                else {
                    $processStatus = false;
                    $response['msg'] = Yii::t("app", "Los datos enviados al servidor son invalidos.");
                }
            }

            if($processStatus) // update process status
            {
                $countTicketForProcess = TicketSearch::find()->innerJoin('process_transaction', 'ticket.process_transaction_id = process_transaction.id')
                    ->innerJoin('process', 'process.id=process_transaction.process_id')
                    ->where(['process.id'=>$processModel->id])->count();

                $countProcessTransaction = ProcessTransaction::find()->where(['process_id'=>$processModel->id])->count();

                if($processModel !== null)
                {
                    if($countTicketForProcess === $countProcessTransaction)
                        $processModel->active =  0;
                    else
                        $processModel->active =  1;
                    $result = $processModel->update();
                    if($result === false)
                    {
                        $processStatus = false;
                        $response['msg'] = 'Ah ocurrido un error al actualizar el estado de la recepción: ' .
                            implode(" ", $processModel->getErrorSummary(false));
                    }
                }
                else {
                    $processStatus = false;
                    $response['msg'] = 'Ah ocurrido un error el proceso no es vaido';
                }
            }

            if($processStatus)
            {

                foreach ($ticketIds as $ticketId) {
                    if($this->generateServiceCardByTicket($ticketId) === false)
                    {
                        $response['warning'] = 'Error al enviar las cartas de servicio.';
                    }
                }
                $response['success'] = true;
                $transaction->commit();

                $response['msg'] = 'Reservas Realizada';
                $response['url'] = Url::to(['/site/index']);
            }
            else
            {
                $response['success'] = false;
                $transaction->rollBack();
            }
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
            //        $sqlChainded = 'SET CHAINED ON';
            //        \Yii::$app->db->createCommand($sqlChainded)->execute();
            $response = $this->notifyNewTickets($processType, $userName, $newTickets);
        }

        return $response;
    }

    protected function notifyNewTickets($processType,
                                        $user,
                                        $tickets)
    {
        $response = [];
        $response['success'] = true;
        $response['tickets'] = [];

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
                $aux->setTimezone(new DateTimeZone("UTC"));
                $dateTicket = $aux->format("Y/m/d H:i");

                $registerTrunk = $processTransaction->register_truck;
                $registerDriver = $processTransaction->register_driver;
                $containerName = $container->name;

                $sql_complete = $sql . $processType . "','".
                                $registerTrunk . "','" .
                                $registerDriver . "','" .
                                $containerName . "','" .
                                $dateTicket . "','" .
                                $user . "'";

                $result = \Yii::$app->db3->createCommand($sql_complete)->queryAll();

                if($result['err_code'] == 1)
                {
                    $response['success'] = false;
                    $response['msg'] = "Ah ocurrido un error al notificar los nuevos turnos.";
                    $response['msg_dev'] = $result['err_msg'];
                    break;
                }
                else {
                    $ticket->acc_id = $result['acc_id'];
                    if(!$ticket->save())
                    {
                        $response['success'] = false;
                        $response['msg'] = "Ah ocurrido un error al actualizar el acceso del turno al TPG.";
                        break;
                    }
                }

                $response['tickets'][] = $ticket;
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
                    else {
                        $ticket->acc_id = 0;
                        if(!$ticket->save())
                        {
                            $response['success'] = false;
                            $response['msg'] = "Ah ocurrido un error al actualizar el acceso del turno al TPG.";
                            $response['msg_dev'] = $result['err_msg'];
                            break;
                        }
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
