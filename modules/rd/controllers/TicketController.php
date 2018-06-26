<?php

namespace app\modules\rd\controllers;

use app\modules\rd\models\Process;
use app\modules\rd\models\ReceptionSearch;
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
                $transaction = Reception::getDb()->beginTransaction();
                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);

                if($model->delete())
                {
                    $calendarSlot->amount++;
                    if(!$calendarSlot->update())
                    {
                        $response['success'] = false;
                        $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: '.
                            implode(" ", $calendarSlot->getErrorSummary(false));

                    }
                }
                else
                {
                    $response['success'] = false;
                    $response['msg'] = 'Ah ocurrido un error al eliminar el ticket: '.
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
                $response['msg'] = $e->getMessage();
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

    public function actionByReception()
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $response['success'] = false;
        $response['msg'] = 'Unknow';

        $receptionId = Yii::$app->request->get('receptionId');


        if(isset($receptionId))
        {
            $tickets = Ticket::find()->innerJoin('process_transaction', 'process_transaction_id=process_transaction.id')
                ->innerJoin('calendar', 'calendar_id=calendar.id')
//                                        ->innerJoin('calendar', 'calendar_id=calendar.id')
                ->where(['process_transaction.process_id'=>$receptionId])
                ->all();
            $response['tickets'] = $tickets;
            $response['success'] = true;
        }
        else{
            $response['msg'] = 'Bad request';
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

                        if(!$processTransaction->update(true, ['register_truck', 'register_driver', 'name_driver']))
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
                                $calendarSlot->amount--;
                                $result = $calendarSlot->update();
                                if($result === false)
                                {
                                    $processStatus = false;
                                    $response['msg'] = 'Ah ocurrido un error al actualizar la disponibilidad del calendario: '.
                                        implode(" ", $oldTicket->getErrorSummary(false));
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
                            $response['msg'] = 'Ah ocurrido un error la recepción no es valida';
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
        return json_encode($response);
    }

}
