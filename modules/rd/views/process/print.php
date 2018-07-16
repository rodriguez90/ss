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


        #datalle td {
            padding: 10px 10px 10px 10px;
            width: 25%;
            border: 1px solid #DDD;
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

        .title{
            font-weight: bold;
        }

    </style>
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
                    <label> <?= date('d/m/Y')?></label>
                </div>
            </td>
        </tr>
    </table>



    <table id="datalle" width="100%">
        <thead>
        <tr>
            <td class="title" > <?= ( $model->type === Process::PROCESS_IMPORT ? 'BL':'Booking' ) ?> </td>
            <td class="title">No.</td>
            <td class="title" >Tipo de trámite</td>
            <td class="title">Fecha de Creación</td>
            <td class="title">Fecha Límite</td>

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
            <tr >
            <td></td>
            <td style='border: solid 1px #DDD;' class="title">Contenedor</td>
            <td style='border: solid 1px #DDD;' class="title">Tipo/Tamaño</td>
            <td style='border: solid 1px #DDD;' class="title">Estado</td>
            <td></td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($transactions as $transaction) {
            $container = $transaction->container;
            echo "<tr >";
            echo "<td></td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container->name . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $container->code . $container->tonnage . "</td>";
            echo "<td style='border: solid 1px #DDD;'>" . $transaction->status . "</td>";
            echo "<td></td>";
            echo "</tr>";
        }
        ?>

        <tr >
        <td ></td>
        <td ></td>
        <td style='font-weight: bold;border: solid 1px #DDD;'>Cantidad de Contenedores</td>
        <td style='font-weight: bold;border: solid 1px #DDD;'><?= $model->getContainerAmount() ?> </td>
        <td ></td>
        </tr>

        </tbody>
    </table>


</div>

</body>
</html>
