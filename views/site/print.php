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
            font-size: 14px;
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

        --></style>
</head>
<body>

<div class="row">

    <h3 style="text-align: center">Solicitudes Realizadas</h3>

<?php if(count($processImp)>0) { ?>
    <h4 style="text-align: left">Importación</h4>

    <table id="datalle" width="100%" >
        <thead>
        <tr>
            <td style="font-weight: bold">Número de Trámite</td>
            <td style="font-weight: bold">BL</td>
            <td style="font-weight: bold">Fecha Límite</td>
            <td style="font-weight: bold">Agencia</td>
            <td style="font-weight: bold">Tipo de Trámite</td>
            <td style="font-weight: bold">Cantidad de Contenedores</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($processImp as $imp) {
            echo "<tr>";
            echo "<td >" . $imp['id']."</td>";
            echo "<td >" . $imp['bl']. "</td>";
            echo "<td >" . $imp['delivery_date'] . "</td>";
            echo "<td >" . $imp->agency->name . "</td>";
            echo "<td >" . Process::PROCESS_LABEL[$imp['type']] . "</td>";
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
                echo "<td >" . $exp['delivery_date'] . "</td>";
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

