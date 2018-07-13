<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 26/06/2018
 * Time: 01:28 PM
 */
use app\modules\rd\models\Process;
use yii\helpers\Url;

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <style type="text/css">

        table {
            font-family: "Helvetica", "Arial", sans-serif;
            font-size: 12px;
            margin-top: 0px;
            width: 100%;
        }

        .info {
            padding: 10px 0px 10px 20px;
        }

        td.btn, td.button {
            vertical-align: middle;
            padding: 5px 0px 5px 0px;
            background: rgb(0, 172, 172) none repeat scroll 0% 0%;
            border-color: rgb(0, 172, 172);
        }

        .btn a, .button a {
            color: rgb(255, 255, 255);
            font-weight: bold;
            text-decoration: none;
            font-family: "Helvetica", "Arial", "sans-serif";
            font-size: 12px;

        }

        #datalle td {
            padding: 10px 10px 10px 10px;
            width: 25%;
            border: 1px solid #DDD;
        }

        .title {
            font-weight: bold;
        }

        #logo {
            position: relative;
            float: left;

        }

        #fecha {
            position: relative;
            float: right;
        }

        #pdfhead td {
            padding: 10px 10px 10px 10px;
            width: 33.333333333333%;
        }

        #links td {
            padding: 10px 10px 10px 10px;
            width: 20%;
        }

    </style>
</head>
<body>

<div class="row">


    <table id="pdfhead" width="100%">
        <tr>
            <td>
                <div id="logo">
                    <img src="<?php echo Yii::$app->homeUrl . "/../img/logo.png"; ?>">
                </div>
            </td>
            <td style="text-align: center"><h4 >NOTIFICACION DE NUEVO PROCESO</h4> </td>
            <td style="text-align: right"><div id="fecha">
                    <label> <?php echo date('d/m/Y');?></label>
                </div>
            </td>
        </tr>
    </table>


    <table id="datalle">
        <thead>
        <tr>
            <td class="title"><?php echo $model->type == Process::PROCESS_IMPORT ? "BL":"Booking";?> </td>
            <td class="title">Fecha Límite</td>
            <td class="title">Agencia</td>
        </tr>

        </thead>
        <tbody>
        <tr>
            <td> <?php echo $model->bl; ?> </td>
            <td> <?php echo  (new \yii\i18n\Formatter())->asDate($model->delivery_date, 'dd/M/yyyy');?> </td>
            <td> <?php echo utf8_encode($model->agency->name); ?> </td>
        </tr>
        </tbody>

    </table>


    <h5 style="text-align: center">Contenedores</h5>

    <table id="links" width="100%">

        <tbody>

        <tr style="text-align: center">
            <td></td>
            <td></td>
            <td class="btn">
                <a href="<?php echo Url::to(['/rd/ticket/create', 'id' => $model->id], true); ?>">Reservar
                    Cupos </a>
            </td>
            <td></td>
            <td></td>
        </tr>

        </tbody>
    </table>


    <table id="contenedores" width="100%" style="text-align: center">

        <tbody>

        <?php

        while (count($containers)>3){
            $i = 4;
            echo "<tr>";
            while($i>0){
                $conten = array_shift($containers);
                echo " <td>" . $conten['name'] . ' ' . $conten['code'] . ' ' . $conten['tonnage'] . "</td>";
                $i--;
            }
            echo "</tr>";
        }

        if(count($containers)>0){
            echo "<tr>";
            while (count($containers)>0){
                $conten = array_shift($containers);
                echo " <td>" . $conten['name'] . ' ' . $conten['code'] . ' ' . $conten['tonnage'] . "</td>";
            }
            echo "</tr>";
        }

        ?>

        </tbody>
    </table>


    <table id="links" width="100%">

        <tbody>


        <tr style="text-align: center">
            <td></td>
            <td></td>
            <td class="btn">
                <a href="<?php echo Url::toRoute(['/rd/ticket/create', 'id' => $model->id], true); ?>">Reservar
                    Cupos </a>
            </td>
            <td></td>
            <td></td>
        </tr>

        </tbody>
    </table>


</div>

</body>
</html>