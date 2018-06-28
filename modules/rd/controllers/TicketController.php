<?php

namespace app\modules\rd\controllers;

use DateTime;
use DateTimeZone;
use app\modules\rd\models\Process;
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
use Yii\web\Response;
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

        $response['success'] = true;
        $response['msg'] = 'Ticket Eliminado';
        $response['ticket'] = $model;

        if($model)
        {
            try {
                $transaction = Ticket::getDb()->beginTransaction();
                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);

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
                $response['success'] = false;
                $response['msg'] = 'Ah ocurrido un error inesperado en el servidor.';
                $response['msg_dev'] = $e->getMessage();
                $transaction->rollBack();
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

        $response['success'] = false;
        $response['msg'] = 'Unknow';
        $customMsg = '';

        if($status === Ticket::PRE_BOOKING)
            $customMsg = 'pre-reserva';
        elseif ($status === Ticket::RESERVE)
            $customMsg = 'reserva';

        $transaction = Process::getDb()->beginTransaction();
        $processStatus = true;

        $ticketIds = [];

        foreach ($tickets as $data)
        {
            $model = new Ticket();
            $model->process_transaction_id = $data['process_transaction_id'];
            $model->calendar_id = $data['calendar_id'];
            $model->active = $data['active'];
            $model->status = $data['status'];

            if($model->validate())
            {
                try {

                    if($processStatus)
                    {
                        $processTransaction = ProcessTransaction::findOne(['id'=>$model->process_transaction_id]);
                        $processTransaction->register_truck = $data['registerTruck'];
                        $processTransaction->register_driver = $data['registerDriver'];
                        $processTransaction->name_driver = $data['nameDriver'];
                        $resul = $processTransaction->update(true, ['register_truck', 'register_driver', 'name_driver']);
                        if($resul === false)
                        {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al actualizar la placa del carro y la cédula del chofer: '.
                                implode(" ", $processTransaction->getErrorSummary(false));
                        }
                    }

                    $oldTicket = Ticket::findOne(['process_transaction_id'=>$model->process_transaction_id]);
                    $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);
                    if($processStatus && $oldTicket) // existe un ticket para esta transaccion
                    {
                        $ticketIds []= $oldTicket->id;;
                        if($oldTicket->active === 1) // activa
                        {
                            if($model->calendar_id !== $oldTicket->calendar_id) // cambio de calendario (fecha) del ticket
                            {
                                $oldCalendarSlot = Calendar::findOne(['id'=>$oldTicket->calendar_id]);
                                $processStatus = $calendarSlot && $calendarSlot->amount > 0;

                                if($processStatus){ // exite el calendario y hay diponibilidad
                                    $oldTicket->calendar_id = $model->calendar_id;
                                    $oldTicket->status = $status;

                                    $processStatus = $oldTicket->update();

                                    if($processStatus)
                                    {
                                        $oldCalendarSlot->amount++;
                                        $calendarSlot->amount--;

                                        if(!$oldCalendarSlot->update() || !$calendarSlot->update())
                                        {
                                            $processStatus = false;
                                            $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: '.
                                                implode(" ", $oldTicket->getErrorSummary(false));
                                        }
                                    }
                                    else {
                                        $processStatus = false;
                                        $response['msg'] = 'Ah ocurrido un error al realizar la ' . $customMsg . ' '.
                                            implode(" ", $oldTicket->getErrorSummary(false));
                                    }
                                }
                                else {
                                    $processStatus = false;
                                    $response['msg'] = 'El calendario seleccionado no esta disponible';
                                }
                            }
                        }
                    }
                    else // nuevo ticket
                    {
                        if($calendarSlot === null)
                        {
                            $processStatus = false;
                            $response['msg'] = 'No fue posible encontrar el calendario.';
                        }

                        if($processStatus)
                        {
                            $processStatus = $calendarSlot->amount > 0;

                            if(!$processStatus)
                            {
                                $processStatus = false;
                                $response['msg'] = 'No hay disponibilidad en el calendario';
                            }

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
                                }
                            }
                            else {
                                $processStatus = false;
                                $response['msg'] = 'Ah ocurrido un error al realizar la ' . $customMsg . ' '.
                                    implode(" ", $model->getErrorSummary(false));
                            }
                        }
                    }

                    if($processStatus) // update reception status
                    {
                        $countTicketForReception = TicketSearch::find()->innerJoin('process_transaction', 'ticket.process_transaction_id = process_transaction.id')
                                                                       ->innerJoin('process', 'process.id=process_transaction.process_id')
                                                                       ->where(['process.id'=>$reception['id']])->count();

                        $countReceptionTransaction = ProcessTransaction::find()->where(['process_id'=>$reception['id']])->count();

                        $processModel = Process::findOne(['id'=>$reception['id']]);

                        if($processModel !== null)
                        {
                            if($countTicketForReception === $countReceptionTransaction)
                                $processModel->active =  0;
                            else
                                $processModel->active =  1;
                            $result = $processModel->update();
                            if($result === false)
                            {
//                                var_dump($processModel->getErrorSummary);die;
                                $processStatus = false;
                                $response['msg'] = 'Ah ocurrido un error al actualizar el estado de la recepción: ' .
                                                    implode(" ", $processModel->getErrorSummary(false));
//                                var_dump($processModel->getErrorSummary(true));die("1");
                            }
                        }
                        else {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error el proceso no es vaido';
                        }
                    }
                }
                catch (Exception $e)
                {
                    $processStatus = false;
                    $response['msg'] = $e->getMessage();
                }
            }
            else {
                $processStatus = false;
                $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
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
//        return json_encode($response);
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
}
