<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 17/06/2018
 * Time: 11:35 PM
 */
use app\modules\rd\models\Process;

?>



<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">


    <style type="text/css"><!--

        table{
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 12px;
            text-align: center;
        }

        body {

            width: auto;
        }

        #datalle td {
            padding: 10px 10px 10px 10px;
            width: 16.66666666666667%;
        }


        } #datalle > tbody > tr > td, #datalle > tbody > tr > th, #datalle > tfoot > tr > td, #datalle > tfoot > tr > th, #datalle > thead > tr > td, #datalle > thead > tr > th{
              border: 1px solid #DDD;
          }

        #logo
        {
            position: relative;
            float: left;

        }
        #fecha{
            position: relative;
            float: right;
        }

        #pdfhead td{
            padding: 10px 10px 10px 10px;
            width: 33.333333333333%;
        }

        #head td {
            padding: 10px 10px 10px 10px;
            width: 16.66666666666667%;

        }


        --></style>
</head>
<body>

<div class="row">

    <table id="pdfhead" width="100%">
        <tr>
            <td>
                <div id="logo">
                    <img src="<?= Yii::$app->homeUrl ?>/../img/logo.png">
                </div>
            </td>
            <td><h4 style="text-align: center">SOLICITUDES REALIZADAS</h4> </td>
            <td><div id="fecha">
                    <label>GUAYAQUIL <?= date('d') . ' de ' . date('F') . ' del ' . date('Y') ?></label>
                </div>
            </td>
        </tr>
    </table>


<?php if(count($processImp)>0) {

    ?>
    <h4 style="text-align: left">Importación</h4>

    <table id='head' width='100%'>
    <thead>
     <tr>
         <td style='background: silver;'> <?= ( $processImp->type === Process::PROCESS_IMPORT ? 'BL':'Booking' ) ?> </td>
         <td style='background: silver;'>No.</td>
         <td style='background: silver;'>Tipo de trámite</td>
         <td style='background: silver;'>Fecha de Creación</td>
         <td style='background: silver;'>Fecha Límite</td>
         <td style='background: silver;'>Cantidad de Contenedores</td>
     </tr>
    </thead>
        <tbody>
     <?php
     foreach ($processImp as $imp) {

         echo "<tr>";
         echo "<td>". $imp->bl ."</td>";
         echo "<td>".$imp->id."</td>";
         $type = $imp->type;
         echo "<td>".Process::PROCESS_LABEL[$type]."</td>";
         $create_at = $imp->created_at;
         echo "<td>".(new \yii\i18n\Formatter())->asDate($create_at , 'dd/M/yyyy')."</td>";
         echo "<td>".(new \yii\i18n\Formatter())->asDate($imp->delivery_date, 'dd/M/yyyy')."</td>";
         echo "<td >" . $imp->getContainerAmount()  . "</td>";
         echo "</tr>";

     }
     ?>
        </tbody>

    </table>

    <?php } ?>



    <?php if(count($processExp)>0) { ?>
        <h4 style="text-align: left">Exportación</h4>

        <table id="datalle" width="100%" >
            <thead>
            <tr>
                <td style="font-weight: bold">Número del Trámite</td>
                <td style="font-weight: bold">BL</td>
                <td style="font-weight: bold">Fecha Límite</td>
                <td style="font-weight: bold">Agencia</td>
                <td style="font-weight: bold">Tipo de Trámite</td>
                <td style="font-weight: bold">Cantidad de Contenedores</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($processExp as $exp) {
                echo "<tr>";
                echo "<td >" . $exp['id']."</td>";
                echo "<td >" . $exp['bl']. "</td>";
                echo "<td >" . (new \yii\i18n\Formatter())->asDate($exp['delivery_date'], 'dd/M/yyyy'). "</td>";
                echo "<td >" . $exp->agency->name . "</td>";
                echo "<td >" . Process::PROCESS_LABEL[$exp['type']] . "</td>";
                echo "<td >" . $exp->getContainerAmount()  . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>

    <?php } ?>


</div>

</body>
</html>

