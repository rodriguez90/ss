<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 17/06/2018
 * Time: 02:05 AM
 */
use app\modules\rd\models\Process;

?>

<!--?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 15/06/2018
 * Time: 07:13 AM
 */
//0a6aa1
?-->





<html>
<head>
    <style>

        body{
            background: #e4f1fb;
            width:210mm;
            height: 297mm;
        }


        table{
            background: #0a6aa1 none repeat scroll 0% 0%;
            padding: 0px 20px 20px 20px;
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 14px;

        }

        table td {
            padding: 10px 10px 10px 10px;
            width: 25%;
        }

        .title{
            background: #0a6aa1;
            color: white;
        }

        .data{
            background: #e4f1fb;
        }

    </style>
</head>
<body>

<?php

$aux = new DateTime( $ticket["start_datetime"] );
$date = $aux->format("YmdHi");

?>

<div class="row" style="background: #e4f1fb;">



    <table>

        <tr>
            <td class="title" > EMP. TRANSPORTE </td>
            <td class="data" > <?php echo $trans_company["name"] ?> </td>
            <td class="title">TICKET NO.</td>
            <td class="data" > <?php  echo  "TI-" . $date . "-".$ticket["id"] ?></td>
        </tr>

        <tr>
            <td class="title" >OPERACION</td>
            <td class="data"  > <?php echo $ticket["type"] ==Process::PROCESS_IMPORT ? "IMPORT":"EXPOT" ?></td>
            <td class="title" >DEPOSITO</td>
            <td class="data"  > <?php echo $ticket["w_name"] ?></td>
        </tr>

        <tr>
            <td class="title" >ECAS</td>
            <td class="data"  >??????</td>
            <td class="title" >F. CADUCIDAD</td>
            <td class="data"  > <?php echo (new \yii\i18n\Formatter())->asDate($ticket["delivery_date"], 'dd/M/yyyy') ?></td>
        </tr>

        <tr>
            <td class="title" >CLIENTE</td>
            <td class="data"  ><?php echo $ticket["a_name"] ?></td>
            <td class="title" >RUC/CI</td>
            <td class="data"  ><?php echo $ticket["ruc"]."/" .$ticket["register_driver"] ?></td>
        </tr>

        <tr>
            <td class="title" >CHOFER</td>
            <td class="data"  ><?php echo $ticket["name_driver"] ?></td>
            <td class="title" >PLACA</td>
            <td class="data"  > <?php echo $ticket["register_truck"] ?></td>
        </tr>

        <tr>
            <td class="title" >FECHA TURNO</td>
            <td class="data"  > <?php echo (new \yii\i18n\Formatter())->asDate($ticket["start_datetime"], 'dd/M/yyyy')?></td>
            <td class="title" >CANTIDAD</td>
            <td class="data"  >1</td>
        </tr>

        <tr>
            <td class="title" >BOOKING</td>
            <td class="data"  ><?php echo $ticket["bl"] ?></td>
            <td class="title" >TIPO CONT</td>
            <td class="data"  > <?php echo $ticket["tonnage"] .$ticket["code"] ?> </td>
        </tr>

        <tr>
            <td class="title" >IMPRESO</td>
            <td class="data"  ><?php echo $dateImp; ?></td>
            <td class="title" >ESTADO</td>
            <td class="data"  > <?php echo $ticket["status"] ==1? "EMITIDO":"---" ?>  </td>
        </tr>


    </table>

    <div style="padding: 20px 0px 0px 0px;">
        <img src="<?=$qr?>" width="300" height="300">
    </div>

</div>

</body>
</html>