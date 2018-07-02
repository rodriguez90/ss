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

        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Ticket::findOne(['id'=>$id, 'active'=>1]);
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

        $response['success'] = true;
        $response['msg'] = 'Ticket Eliminado';
        $response['ticket'] = $model;

        if($model)
        {
            try {
                $transaction = Ticket::getDb()->beginTransaction();
                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);

                $result = $this->spTicketDelete($model->acc_id, $user->nombre);

                if($model->delete())
                {
                    $calendarSlot->amount++;
                    $result = $calendarSlot->update();
                    if($result === false)
                    {
                        $response['success'] = false;
                        $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario.';
                        $response['msg_dev'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: '.
                            implode(" ", $calendarSlot->getErrorSummary(false));
                    }
                }
                else
                {
                    $response['success'] = false;
                    $response['msg'] = 'Ah ocurrido un error al eliminar el ticket.'.
                    $response['msg_dev'] = 'Ah ocurrido un error al eliminar el ticket: '.
                        implode(" ", $model->getErrorSummary(false));
                }

                if($response['success'] == true)
                {
                    $transaction->commit();
                }
                else {
                    $transaction->rollBack();
                }
            }
            catch (\Exception $e)
            {
                if($e->getCode() !== '01000')
                {
                    $response['success'] = false;
                    $response['msg'] = 'Ah ocurrido un error inesperado en el servidor.';
                    $response['msg_dev'] = $e->getMessage();
                    $transaction->rollBack();
                }
            }
        }
        else {
            $response['success'] = false;
            $response['msg'] = 'El ticket no existe';
        }

        return $response;
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

        // TPG NOTTFIE
        $processType = $processModel->type == Process::PROCESS_IMPORT ? 'IMPO':'EXPO';
        $user = AdmUser::findOne(['id'=>Yii::$app->user->getId()]);

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

                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);
                $dateTicket = '';

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

                if($calendarSlot)
                    $dateTicket = date_format($calendarSlot->start_datetime, 'Y/m/d H:i');

                if($model->validate()) // validate model
                {
                    if($processStatus)
                    {
                        $processTransaction = ProcessTransaction::findOne(['id'=>$model->process_transaction_id]);
                        $processTransaction->register_truck = $data['registerTruck'];
                        $processTransaction->register_driver = $data['registerDriver'];
                        $processTransaction->name_driver = $data['nameDriver'];
                        $result = $processTransaction->update(true, ['register_truck', 'register_driver', 'name_driver']);
                        if($result === false)
                        {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al actualizar la placa del camión y los datos del chofer: '.
                                implode(" ", $processTransaction->getErrorSummary(false));
                            break;
                        }
                    }

                    if($processStatus) // nuevo ticket
                    {

                        $result = $this->spTicketInsert($processType,
                            $processTransaction->register_truck,
                            $processTransaction->register_driver,
                            $processTransaction->container->name,
                            $dateTicket,
                            $user->nombre);

                        if($result['err_code'] !== 0)
                        {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al notifica a TPG sobre el nuevo turno.';
                            break;
                        }

                        $model->acc_id = $result['acc_id'];

                        if($processStatus)
                        {
                            $model->status = $status;
                            $processStatus = $model->save();
                            if(!$processStatus)
                            {
                                $processStatus = false;
                                $response['msg'] = 'Ah ocurrido un error al crear el cupo.';
                                $response['msg_dev'] = 'Ah ocurrido un error al crear el cupo'.
                                    implode(" ", $model->getErrorSummary(false));
                                break;
                            }
                            else
                            {
                                $ticketIds []= $model->id;
                            }
                            $calendarSlot->amount--;
                            $result = $calendarSlot->update();
                            if($result === false)
                            {
                                $processStatus = false;
                                $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: '.
                                    implode(" ", $calendarSlot->getErrorSummary(false));
                                break;
                            }
                        }
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
                    if($countTicketForReception === $countProcessTransaction)
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

            if($processStatus) {
                foreach ($ticketIds as $ticketId) {
                    if($this->generateServiceCardByTicket($ticketId) === false)
                    {
                        $processStatus = false;
                        $response['msg'] = 'Ah ocurrido un error al generar las cartas de servicio.';
                        break;
                    }
                }
            }

            if($processStatus)
            {
                $transaction->commit();
                $response['success'] = true;
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
                $response['success'] = false;
                $response['msg'] = 'Ah ocurrido un error al generar los ticket.';
            }

        }

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

    protected function spTicketInsert($processType, $registerTrunk, $registerDriver, $container, $dateTicket, $user)
    {
        $result = null;
        try
        {
            $sql = 'exec  disv..sp_sgt_access_ins '. $processType . ',' . $registerTrunk . ',' . $registerDriver . ',' . $container . ',' . $dateTicket . ',' . '$user';
            $result = \Yii::$app->db->createCommand($sql)->queryAll();
        }
        catch (Exception $exception)
        {
            $result['err_code'] = 1;
            $result['err_msg'] = $exception->getMessage();
        }

        return $result;
    }

    protected function spTicketDelete($accId, $user)
    {

        $result = null;
        try
        {
//            exec disv..sp_sgt_access_elimina 7316061, 'test'
            $sql = 'exec  disv..sp_sgt_access_elimina '. $accId . ',' . $user;
            $result = \Yii::$app->db->createCommand($sql)->queryAll();
        }
        catch (Exception $exception)
        {
            $result['err_code'] = 1;
            $result['err_msg'] = $exception->getMessage();
        }

        return $result;
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
}
