<?php

/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 07/09/2018
 * Time: 15:30
 */

namespace app\tools;

use DateTime;
use DateTimeZone;
use app\modules\rd\models\Process;
use app\modules\rd\models\ProcessTransaction;
use app\modules\rd\models\Ticket;
use Da\QrCode\QrCode;
use Yii;


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
     * This function update the acc_id for tickets
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
            $sql = "exec disv..sp_sgt_access_ins '";
//            $sql = "exec  disv..sp_sgt_access_ins :processType,:registerTrunk,:registerDriver,:containerName,:dateTicket,:user,:bl";

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
//                $result = Yii::$app->db3->createCommand($sql)
//                    ->bindValue(':processType', $processType)
//                    ->bindValue(':registerTrunk', $registerTrunk)
//                    ->bindValue(':registerDriver', $registerDriver)
//                    ->bindValue(':containerName', $containerName)
//                    ->bindValue(':dateTicket', $dateTicket)
//                    ->bindValue(':user', $user)
//                    ->bindValue(':bl', $bl)
//                    ->queryAll();

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

    /**
     * @param $tickets
     * @param $user
     * @return array
     */
    static function notifyDeletedTickets($tickets, $user)
    {

        $response = [];
        $response['success'] = true;
        $response['tickets'] = [];

        try
        {
//            exec disv..sp_sgt_access_elimina 7316061, 'test'
            $sql = "exec disv..sp_sgt_access_elimina ";
//            $sql = "exec  disv..sp_sgt_access_elimina :accId,:user";

            foreach ($tickets as $ticket)
            {
                if($ticket->acc_id)
                {
                    $sqlCompleted = $sql . $ticket->acc_id . ",'" . $user . "'";

                    $result = \Yii::$app->db3->createCommand($sqlCompleted)->queryAll();
//                    $result = \Yii::$app->db3->createCommand($sql)
//                        ->bindValue(':accId', $ticket->acc_id)
//                        ->bindValue(':user', $user)
//                        ->queryAll();

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

    /**
     * @param $serviceCardData
     */
    static function generateServiceCardQr($serviceCardData)
    {
        $imageString = '';

        if(isset($serviceCardData['startDatetime']) &&
            isset($serviceCardData['createdAt']) &&
            isset($serviceCardData['transCompanyName']) &&
            isset($serviceCardData['id']) &&
            isset($serviceCardData['processType']) &&
            isset($serviceCardData['warehouseName']) &&
            isset($serviceCardData['deliveryDate']) &&
            isset($serviceCardData['agencyName']) &&
            isset($serviceCardData['nameDriver']) &&
            isset($serviceCardData['registerDriver']) &&
            isset($serviceCardData['registerTruck']) &&
            isset($serviceCardData['tonnage']) &&
            isset($serviceCardData['code']) &&
            isset($serviceCardData['name']) &&
            isset($serviceCardData['status']) &&
            isset($serviceCardData['bl']))
        {
            $aux = new DateTime( $serviceCardData["startDatetime"]);
            $date = $aux->format("YmdHi");
            $serviceCardData["startDatetime"] = $aux->format("d-m-Y H:i");
            $dateImp = new DateTime($serviceCardData["createdAt"]);
            $dateImp = $dateImp->format('d-m-Y H:i');

            $info = '';
            $info .= "EMP. TRANSPORTE: " . $serviceCardData["transCompanyName"] . ' ';
            $info .= "TICKET NO: TI-" . $date . "-" . $serviceCardData["id"] . ' ';
            $info .= "OPERACIÓN: " . $serviceCardData["processType"] == Process::PROCESS_IMPORT ? "IMPORTACIÓN":"EXPORTACIÓN" . '  ';
            $info .= "DEPÓSITO: " . $serviceCardData["warehouseName"] . ' ';
            $info .= "ECAS: " . $serviceCardData["deliveryDate"] . ' ';
            $info .= "CLIENTE: " . $serviceCardData["agencyName"] . ' ';
            $info .= "CHOFER: " . $serviceCardData["nameDriver"] . "/" . $serviceCardData["registerDriver"] . ' ';
            $info .= "PLACA: " . $serviceCardData["registerTruck"] . ' ';
            $info .= "FECHA TURNO: " . $serviceCardData["startDatetime"] . ' ';
            $info .= "CANTIDAD: 1" . ' ';
            $info .= ($serviceCardData["processType"] == Process::PROCESS_IMPORT ? "BL":"BOOKING") . ": ". $serviceCardData["bl"] . ' ';
            $info .= "CONT: " . $serviceCardData["name"];
            $info .= "TIPO CONT: " . $serviceCardData["tonnage"] . $serviceCardData["code"] . ' ';
            $info .= "GENERADO: " . $dateImp . ' ';
            $info .= "ESTADO: " . $serviceCardData["status"] == 1 ? "EMITIDO" : "---";

            ob_start();
            \QRcode::png($info,null);
            $imageString = base64_encode(ob_get_contents());
            ob_end_clean();
        }

        return $imageString;
    }
}