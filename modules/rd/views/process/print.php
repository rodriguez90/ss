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


        #datalle td {
            padding: 10px 10px 10px 10px;
            width: 25%;
        }

        #contenedores td {
            padding: 10px 10px 10px 10px;
            width: 25%;
        }

        #contenedores > tbody > tr > td, #contenedores > tbody > tr > th, #contenedores > tfoot > tr > td, #contenedores > tfoot > tr > th, #contenedores > thead > tr > td, #contenedores > thead > tr > th{
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


        --></style>
</head>
<body>

<div class="row">

    <table id="pdfhead" width="100%" style="margin-bottom: 20px;">
        <tr>
            <td>
                <div id="logo">
                    <img src="<?= Yii::$app->homeUrl ?>/../img/logo.png"?>
                </div>
            </td>
            <td style="text-align: center"><h4 >DETALLES DEL PROCESO</h4> </td>
            <td style="text-align: right"><div id="fecha">
                    <label>GUAYAQUIL <?= date('d') . ' de ' . date('F') . ' del ' . date('Y') ?></label>
                </div>
            </td>
        </tr>
    </table>



    <table id="datalle" width="100%">
        <thead>
        <tr>
            <td style='background: silver;'> <?= ( $processImp->type === Process::PROCESS_IMPORT ? 'BL':'Booking' ) ?> </td>
            <td style='background: silver;'>No.</td>
            <td style='background: silver;'>Tipo de trámite</td>
            <td style='background: silver;'>Fecha de Creación</td>
            <td style='background: silver;'>Fecha Límite</td>

        </tr>
        </thead>
        <tbody>
        <?php
        echo "<tr>";
            echo "<td>". $model->bl ."</td>";
            echo "<td>".$model->id."</td>";
            $type = $model->type;
            echo "<td>".Process::PROCESS_LABEL[$type]."</td>";
            $create_at = $model->created_at;
            echo "<td>".(new \yii\i18n\Formatter())->asDate($create_at , 'dd/M/yyyy')."</td>";
            echo "<td>".(new \yii\i18n\Formatter())->asDate($model->delivery_date, 'dd/M/yyyy')."</td>";

            echo "</tr>";
        ?>


        </tbody>

    </table>

    <h5 style="text-align: center">Contenedores</h5>

    <table id="contenedores" width="100%" >
        <thead>
            <tr style='font-weight: bold;text-align: left;'>
            <td></td>
            <td style='border: solid 1px #DDD;background: silver;'>Contenedor</td>
            <td style='border: solid 1px #DDD;background: silver;'>Tipo/Tamaño</td>
            <td style='border: solid 1px #DDD;background: silver;'>Estado</td>
            <td></td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($contenedores as $contenedor) {
            echo "<tr >";
            echo "<td></td>";
            echo "<td style='border: solid 1px #DDD;'>" . $contenedor['name'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $contenedor['code'] . $contenedor['tonnage'] . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $contenedor['status'] . "</td>";
            echo "<td></td>";
            echo "</tr>";
        }
        ?>

        <tr >
        <td ></td>
        <td ></td>
        <td style='font-weight: bold;border: solid 1px #DDD;background: silver;'>Cantidad de Contenedores</td>
        <td style='font-weight: bold;border: solid 1px #DDD;background: silver;'><?= $model->getContainerAmount() ?> </td>
        <td ></td>
        </tr>

        </tbody>
    </table>


</div>

</body>
</html>
