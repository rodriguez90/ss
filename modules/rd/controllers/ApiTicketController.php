<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 09/06/2018
 * Time: 9:47
 */

namespace app\modules\rd\controllers;


use app\modules\administracion\models\AdmUser;
use app\modules\rd\models\Calendar;
use app\modules\rd\models\Container;
use app\modules\rd\models\Reception;
use app\modules\rd\models\ReceptionTransaction;
use app\modules\rd\models\Ticket;
use vakata\database\Exception;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\Response;


class ApiTicketController extends  ActiveController
{
    public $modelClass = 'app\modules\rd\models\Ticket';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    /* Declare methods supported by APIs */
    protected function verbs(){
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'reserve' => ['POST'],
            'prebooking' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    public function behaviors()
    {
        // remove rateLimiter which requires an authenticated user to work
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    public function actionDelete($id)
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = Ticket::findOne(['id'=>$id, 'active'=>1]);

        $response['success'] = true;
        $response['msg'] = 'Ticket Eliminado';

        if($model)
        {
            try {
                $transaction = Reception::getDb()->beginTransaction();
                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);

                if($model->delete())
                {
                    $calendarSlot->amount--;
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

        return json_encode($response);
    }

    public function actionReserve()
    {
        return $this->doTicket(Ticket::RESERVE);
    }

    public function actionPrebooking()
    {
        return $this->doTicket(Ticket::PRE_BOOKING);
    }

    private function doTicket($status)
    {
        $response = array();

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Ticket();

        $response['success'] = false;
        $response['msg'] = 'Unknow';
        $customMsg = '';

        if($status === Ticket::PRE_BOOKING)
            $customMsg = 'pre-reserva';
        elseif ($status === Ticket::RESERVE)
            $customMsg = 'reserva';


        if($model->load(Yii::$app->request->post()))
        {
            $transaction = Reception::getDb()->beginTransaction();
            $processStatus = true;

            try {
                $oldTicket = Ticket::findOne(['process_transaction_id'=>$model->process_transaction_id]);
                $calendarSlot = Calendar::findOne(['id'=>$model->calendar_id]);
                if($oldTicket) // existe un ticket para esta transaccion
                {
                    if($oldTicket->active === 1) // activa
                    {
                        if($model->calendar_id !== $oldTicket->calendar_id) // cambio de calendario (fecha) del ticket
                        {
                            $oldCalendarSlot = Calendar::findOne(['id'=>$oldTicket->calendar_id]);
                            $processStatus = $calendarSlot && $calendarSlot->count > 0;

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
                    $processStatus = $calendarSlot && $calendarSlot->count > 0;
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
                        $response['msg'] = 'El calendario seleccionado no esta disponible';
                    }
                }

                if($processStatus)
                {
                    $transaction->commit();

                    $response['success'] = true;
                    $response['msg'] = 'Pre-reserva Realizada';
                }
                else
                {
                    $response['success'] = false;
                    $transaction->rollBack();
                }
            }
            catch (Exception $e)
            {
                $response['success'] = false;
                $response['msg'] = $e->getMessage();
                $transaction->rollBack();
            }
        }
        else {
            $response['success'] = false;
            $response['msg'] = Yii::t("app", "No fue posible procesar los datos.");
        }

        return json_encode($response);
    }
}