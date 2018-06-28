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

        #contenedores td {
            padding: 10px 10px 10px 10px;
            width: 33.3333333333333%;


        } #contenedores > tbody > tr > td, #contenedores > tbody > tr > th, #contenedores > tfoot > tr > td, #contenedores > tfoot > tr > th, #contenedores > thead > tr > td, #contenedores > thead > tr > th{
              border: 1px solid #DDD;
          }

        --></style>
</head>
<body>

<div class="row">

    <h3 style="text-align: center">Detalles Proceso</h3>

    <table id="datalle" width="100%">
        <tbody>
        <tr>
            <td>No.</td>
            <td> <?= $model->id ?></td>
            <td>Tipo de trámite</td>
            <td> <?= Process::PROCESS_LABEL[$model->type] ?></td>
            <td>Fecha de Creación</td>
            <td> <?= (new \yii\i18n\Formatter())->asDate($model->created_at, 'dd/M/yyyy') ?></td>
        </tr>
        <tr>
            <td><?php echo $model->type === Process::PROCESS_IMPORT ? "BL":"Booking"?></td>
            <td><?= $model->bl ?></td>
            <td>Fecha Límite</td>
            <td> <?= (new \yii\i18n\Formatter())->asDate($model->delivery_date, 'dd/M/yyyy') ?></td>
            <td>Cantidad</td>
            <td>  <?= $model->getContainerAmount() ?> </td>
        </tr>

        </tbody>

    </table>

    <h3 style="text-align: center">Contenedores</h3>

    <table id="contenedores" width="100%" >
        <thead>
        <tr>
            <td style="font-weight: bold">Contenedor</td>
            <td style="font-weight: bold">Tipo/Tamaño</td>
            <td style="font-weight: bold">Estado</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($contenedores as $contenedor) {
            echo "<tr>";
            echo "<td style='width: 33.33333333333333%;'>" . $contenedor['name'] . "</td>";
            echo "<td style='width: 33.33333333333333%;'>" . $contenedor['code'] . $contenedor['tonnage'] . "</td>";
            echo "<td style='width: 33.33333333333333%;'>" . $contenedor['status'] . "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>


</div>

</body>
</html>
