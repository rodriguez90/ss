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

        table {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 12px;
            margin-top: 10px;
            text-align: center;
        }


        body {

            width: auto;
        }

        #head td {
            padding: 10px 10px 10px 10px;
            width: 16.66666666666667%;

        }

        #containers td {
            padding: 10px 10px 10px 10px;
            width: 20%;

        }

        #head  td{
            border: 1px solid #DDD;

        }

        h4{
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .container-info{
            text-align: left;
        }




    </style>

</head>
<body>

<div class="row">

    <h4 style="text-align: center">Procesos</h4>

    <?php

    foreach ($result as $row){
        echo "<table id='head' width='100%'>";
        echo "<tbody>";

        echo "<tr>";
        echo "<td style='background: silver;'>" . ( $type === Process::PROCESS_IMPORT ? 'BL':'Booking' ) ."</td>";
        echo "<td style='background: silver;'>No.</td>";
        echo "<td style='background: silver;'>Tipo de trámite</td>";
        echo "<td style='background: silver;'>Fecha de Creación</td>";
        echo "<td style='background: silver;'>Fecha Límite</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>". $row['process']->bl ."</td>";
        echo "<td>".$row['process']->id."</td>";
        $type = $row['process']->type;
        echo "<td>".Process::PROCESS_LABEL[$type]."</td>";
        $create_at = $row['process']->created_at;
        echo "<td>".(new \yii\i18n\Formatter())->asDate($create_at , 'dd/M/yyyy')."</td>";
        echo "<td>".(new \yii\i18n\Formatter())->asDate($row['process']->delivery_date, 'dd/M/yyyy')."</td>";
        echo "</tr>";

        echo "</tbody>";
        echo "</table>";


        echo "<h5 style='text-align: center'>Contenedores</h5>";

        echo "<table id='containers' width='100%'>";
        echo "<thead>";
        echo "<tr style='font-weight: bold;text-align: left;' >";
        echo "<td></td>";
        echo "<td style='border: solid 1px #DDD;background: silver;'>Contenedor</td>";
        echo "<td style='border: solid 1px #DDD;background: silver;'>Tipo/Tamaño</td>";
        echo "<td style='border: solid 1px #DDD;background: silver;'>Fecha del Turno</td>";
        echo "<td></td>";
        echo "</tr>";
        echo "</thead>";


        echo "<tbody>";
        foreach ($row['containers'] as $container) {
            echo "<tr class='container-info'>";
            echo "<td></td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container['name'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container['code'] . $container['tonnage'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . (new \yii\i18n\Formatter())->asDate($container['start_datetime'], 'dd/M/yyyy') . "</td>";
            echo "<td></td>";
            echo "</tr>";
        }

        echo "<tr >";
        echo "<td ></td>";
        echo "<td ></td>";
        echo "<td style='font-weight: bold;border: solid 1px #DDD;background: silver;'>Total</td>";
        echo "<td style='font-weight: bold;border: solid 1px #DDD;background: silver;'>". $row['process']->getContainerAmount()."</td>";
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
