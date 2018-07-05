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




        #info{

            padding: 0px 20px 0px 20px;
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 12px;

        }



        table td {
            padding: 10px 10px 10px 10px;
            width: 25%;
        }

        .title{
            font-weight: bold;
        }





    </style>
</head>
<body>

<?php

$aux = new DateTime( $ticket["start_datetime"] );
$date = $aux->format("YmdHi");

?>


<table id="pdfhead" width="100%" style="margin-bottom: 0px;">
    <tr>
        <td>
            <div id="logo">
                <img src="<?= Yii::$app->homeUrl ?>/../img/logo.png"?>
            </div>
        </td>
        <td style="text-align: center;" ><h4 >DETALLES DEL PROCESO</h4> </td>
        <td style="text-align: right;" ><div id="fecha" >
                <label> <?= date('d/m/Y')?></label>
            </div>
        </td>
    </tr>
</table>



<div class="row" >



    <table width="100%" id="info">

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
            <td class="data"  ><?php echo (new \yii\i18n\Formatter())->asDate($ticket["delivery_date"], 'dd/M/yyyy') ?></td>
            <td class="title" >FECHA LIMITE</td>
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
            <td class="data"  > <?php echo (new \yii\i18n\Formatter())->asDate($ticket["start_datetime"], 'dd/M/yyyy H:i')?></td>
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
            <td class="title" >GENERADO</td>
            <td class="data"  ><?php echo $dateImp; ?></td>
            <td class="title" >ESTADO</td>
            <td class="data"  > <?php echo $ticket["status"] ==1? "EMITIDO":"---" ?>  </td>
        </tr>


    </table>

    <div style="padding: 5px 0px 5px 5px;">
        <img src="<?=$qr?>" width="250" height="250">
    </div>

</div>

</body>
</html>