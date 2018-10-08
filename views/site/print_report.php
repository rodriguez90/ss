<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 17/06/2018
 * Time: 08:31 PM
 */
use app\modules\rd\models\Process;

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">



    <style type="text/css">


        table{

            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 12px;
            margin-top: 0px;
            width: 100%;
        }


        body {

            width: auto;
        }

        #head td {
            padding: 10px 10px 10px 10px;
            width: 33.333333333333%;

        }

        #containers td {
            padding: 10px 10px 10px 10px;
            width: 16.6666666667%;

        }

        #head  td{
            border: 1px solid #DDD;

        }

        h4,h5{
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .container-info{
            text-align: left;
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

        .title{
            font-weight: bold;
        }

    </style>

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
            <td style="text-align: center"><h4 >DETALLES DE PROCESOS</h4> </td>
            <td style="text-align: right"><div id="fecha">
                    <label> <?= date('d/m/Y')?></label>
                </div>
            </td>
        </tr>
    </table>




    <?php

    foreach ($result as $row){
        echo "<table id='head' width='100%'>";
        echo "<tbody>";
        $type = $row['process']->type;
        echo "<tr>";
        echo "<td  class='title' >" . ( $type == Process::PROCESS_IMPORT ? 'BL':'Booking' ) ."</td>";
        echo "<td  class='title' >Tipo de trámite</td>";
        echo "<td class='title' >Fecha Límite</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>". $row['process']->bl ."</td>";
        echo "<td>".Process::PROCESS_LABEL[$type]."</td>";
        echo "<td>".(new \yii\i18n\Formatter())->asDate($row['process']->delivery_date, 'dd/M/yyyy')."</td>";
        echo "</tr>";

        echo "</tbody>";
        echo "</table>";


        echo "<h5 style='text-align: center;'>Contenedores</h5>";

        echo "<table id='containers' width='100%'>";
        echo "<thead>";
        echo "<tr >";
        echo "<td></td>";
        echo "<td style='border: solid 1px #DDD;font-weight: bold;'>Contenedor</td>";
        echo "<td style='border: solid 1px #DDD;font-weight: bold;'>Tipo/Tamaño</td>";
        echo "<td style='border: solid 1px #DDD;font-weight: bold;'>Estado</td>";
        echo "<td style='border: solid 1px #DDD;font-weight: bold;'>Fecha del Turno</td>";

        echo "<td></td>";
        echo "</tr>";
        echo "</thead>";


        echo "<tbody>";
        foreach ($row['containers'] as $container) {
            echo "<tr class='container-info'>";
            echo "<td></td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container['name'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container['code'] . $container['tonnage'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container['status'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . ( $container['start_datetime'] == "" ? "" : (new \yii\i18n\Formatter())->asDate($container['start_datetime'], 'dd/M/yyyy H:i') ) . "</td>";
            echo "<td></td>";
            echo "</tr>";
        }

        echo "<tr >";
        echo "<td ></td>";
        echo "<td ></td>";
        echo "<td style='font-weight: bold;border: solid 1px #DDD;'>Total</td>";
        echo "<td style='font-weight: bold;border: solid 1px #DDD;'>". $row['process']->getContainerAmount()."</td>";
        echo "<td ></td>";
        echo "</tr>";

        echo "<tr >";
        echo "<td ></td>";
        echo "<td ></td>";
        echo "<td ></td>";
        echo "<td ></td>";
        echo "<td ></td>";
        echo "</tr>";

        echo "</tbody>";
        echo "</table>";


    }


    ?>

</div>

</body>
</html>
