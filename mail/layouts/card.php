<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 17/06/2018
 * Time: 02:05 AM
 */
use app\modules\rd\models\Process;

?>

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

?>


<table id="pdfhead" width="100%" style="margin-bottom: 0px;">
	<tbody>
		<tr>
			<td>
				<div id="logo">
					<img src="<?= Yii::$app->homeUrl ?>/../img/logo.png"?>
				</div>
			</td>
			<td style="text-align: center;" ><h4 >DETALLES DEL TURNO</h4> </td>
			<td style="text-align: right;" >
				<div id="fecha" >
					<label> <?= date('d/m/Y')?></label>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<div class="row" >
    <table width="100%" id="info">
		<tbody>
			<tr>
				<td class="title" > EMP. TRANSPORTE </td>
				<td class="data" > <?php echo utf8_encode($trans_company["name"]) ?> </td>
				<td class="title">TICKET NO.</td>
				<td class="data" > <?php  echo  "TI-" . $date . "-".$ticket["id"] ?></td>
			</tr>

			<tr>
				<td class="title" >OPERACIÓN</td>
				<td class="data"  > <?php echo $ticket["type"] ==Process::PROCESS_IMPORT ? "IMPORTACIÓN":"EXPORTACIÓN" ?></td>
				<td class="title" >DEPÓSITO</td>
				<td class="data"  > <?php echo $ticket["w_name"] ?></td>
			</tr>

			<tr>
				<td class="title" >ECAS</td>
				<td class="data"  ><?php echo (new \yii\i18n\Formatter())->asDate($ticket["delivery_date"], 'dd/M/yyyy') ?></td>
                <td class="title" >CLIENTE</td>
                <td class="data"  ><?php echo utf8_encode($ticket["a_name"] )?></td>
			</tr>

			<tr>
				<td class="title" >CHOFER</td>
				<td class="data"  ><?php echo utf8_encode($ticket["name_driver"]) . "/" .$ticket["register_driver"]?></td>
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
				<td class="title" ><?php echo $ticket["type"] ==Process::PROCESS_IMPORT ? "BL":"BOOKING" ?></td>
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
		</tbody>


    </table>

    <div style="padding: 5px 0px 5px 5px;">
        <img src="<?=$qr?>" width="250" height="250">
    </div>

</div>

</body>
</html>