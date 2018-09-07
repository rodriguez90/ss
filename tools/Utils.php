<?php

/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 07/09/2018
 * Time: 15:30
 */

namespace app\tools;

use app\modules\rd\models\ProcessTransaction;
use app\modules\rd\models\Ticket;


class Utils
{
    /**
     * @param $processType
     * @param $bl
     * @param $user
     * @param $tickets
     * @return array multiple with keys
     *      bolean success
     *      string msg
     *      string msg_dev
     */
    static function notifyNewTickets($processType,
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

    static function notifyDeletedTickets($tickets, $user)
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