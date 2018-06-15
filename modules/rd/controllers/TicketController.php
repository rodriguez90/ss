<?php

namespace app\modules\rd\controllers;

use Yii;
use app\modules\rd\models\Ticket;
use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\TicketSearch;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionTransaction;
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
//    public function actionAdd()
//    {
////        $model = new Ticket();
////
////        if ($model->load(Yii::$app->request->post()) && $model->save()) {
////            return $this->redirect(['view', 'id' => $model->id]);
////        }
//
//        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);
//        if($user && !($user->hasRol('Cia_transporte')))
//            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos en la recepción');
//
//        return $this->render('_form', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    public function actionTransCompany($id)
    {
        $user = AdmUser::findOne(['id'=>Yii::$app->user->id]);

        if(!Yii::$app->user->can("ticket_create"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

//        if($user && !($user->hasRol('Cia_transporte')))
//            throw new ForbiddenHttpException('Usted no tiene permiso para resevar cupos en la recepción');

        return $this->render('_form', [
            'model' => $this->findModel($id),
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
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

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
        return $this->doTicket($tickets, Ticket::RESERVE);
    }

    public function actionPrebooking()
    {
        if(!Yii::$app->user->can("ticket_update"))
            throw new ForbiddenHttpException('Usted no tiene permiso ver esta vista');

        $tickets = Yii::$app->request->post('tickets');
        return $this->doTicket($tickets, Ticket::PRE_BOOKING);
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
            $tickets = Ticket::find()->innerJoin('reception_transaction', 'reception_transaction_id=reception_transaction.id')
                                        ->innerJoin('calendar', 'calendar_id=calendar.id')
//                                        ->innerJoin('calendar', 'calendar_id=calendar.id')
                                        ->where(['reception_transaction.reception_id'=>$receptionId])
                                        ->all();
            $response['tickets'] = $tickets;
            $response['success'] = true;
        }
        else{
            $response['msg'] = 'Bad request';
        }

        return $response;
    }

    private function doTicket($tickets, $status)
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

        $transaction = Reception::getDb()->beginTransaction();
        $processStatus = true;

        foreach ($tickets as $data)
        {
            $model = new Ticket();
            $model->reception_transaction_id = $data['reception_transaction_id'];
            $model->calendar_id = $data['calendar_id'];
            $model->active = $data['active'];
            $model->status = $data['status'];

            if($model->validate())
            {
                try {

                    if($processStatus)
                    {
                        $receptionTransaction = ReceptionTransaction::findOne(['id'=>$model->reception_transaction_id]);
                        $receptionTransaction->regiter_truck = $data['registerTruck'];
                        $receptionTransaction->register_driver = $data['registerDriver'];
                        $receptionTransaction->name_driver = $data['nameDriver'];

                        if(!$receptionTransaction->update(true, ['regiter_truck', 'register_driver', 'name_driver']))
                        {
                            $processStatus = false;
                            $response['msg'] = 'Ah ocurrido un error al actualizar la placa del carro y la cédula del chofer: '.
                                implode(" ", $receptionTransaction->getErrorSummary(false));
                        }
                    }

                    $oldTicket = Ticket::findOne(['reception_transaction_id'=>$model->reception_transaction_id]);
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
                        $processStatus = $processStatus && $calendarSlot && $calendarSlot->amount > 0;
                        if($processStatus)
                        {
                            $model->status = $status;
                            $processStatus = $model->save();
                            if($processStatus)
                            {
                                $calendarSlot->amount--;
                                $processStatus = $calendarSlot->update();
                                if(!$processStatus)
                                {
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
                        else
                        {
                            $processStatus = false;
                            $response['msg'] = 'No hay disponibilidad en el calendario';
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
            $response['url'] = Url::to('/site/index');
        }
        else
        {
            $response['success'] = false;
            $transaction->rollBack();
        }
        return json_encode($response);
    }

}
