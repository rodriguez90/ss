<?php
/**
 * Created by PhpStorm.
 * User: yopt
 * Date: 15/06/2018
 * Time: 07:13 AM
 */
use yii\helpers\Url;

?>


<head>

    <style type="text/css">


        body {
            background: rgb(217, 224, 231) none repeat scroll 0% 0%;
            width: 550px;
        }

        table {
            background: rgb(45, 53, 60) none repeat scroll 0% 0%;
            width: 500px;
            margin: 0px;
            text-align: left;

        }

        .info {
            padding: 10px 0px 10px 20px;
        }

        td {
            color: rgb(168, 172, 177) ! important;
        }

        .row h1, .row h2, .row h3, .row h4, .row h5, .row h6 {
            color: rgb(255, 255, 255) ! important;
            margin-bottom: 0px;
            font-family: "Helvetica", "Arial", sans-serif;
        }

        td.wrapper {
            padding: 15px 15px 0px;
        }

        td.btn, td.button {
            vertical-align: middle ! important;
            padding: 6px 0px ! important;
            background: rgb(0, 172, 172) none repeat scroll 0% 0% ! important;
            border-color: rgb(0, 172, 172) ! important;
        }

        .btn a, .button a {
            color: rgb(255, 255, 255) ! important;
            font-weight: normal ! important;
            text-decoration: none ! important;
            font-family: "Helvetica", "Arial", "sans-serif";
            font-size: 12px;
        }

        td.btn:hover, td.button:hover, td.btn:visited, td.button:visited, table.btn:active, td.button:active {
            background: rgb(0, 138, 138) none repeat scroll 0% 0% ! important;
            border-color: rgb(0, 138, 138) ! important;
        }

        li, p {
            margin-top: 0px;
            font-family: "Helvetica", "Arial", "sans-serif";
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="row">
    <table>
        <tbody>
        <tr>
            <td>

                <!-- begin six columns -->
                <table class="info">
                    <tbody>
                    <tr style="text-align: center">
                        <td>
                            <h3 style="margin:0; padding:0; margin-bottom:5px;">Notificación de nueva recepción</h3>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <h4 style="margin:0; padding:0; margin-bottom:15px;">Detalles:</h4>


                            <table class="four columns">
                                <tr>
                                    <td style="padding-right: 25px;">
                                        <h5>Nro</h5>
                                        <p> <?= $model->id ?></p>
                                    </td>

                                    <td style="padding-right: 25px;">

                                        <h5>BL </h5>
                                        <p> <?= $model->bl ?></p>
                                    </td>

                                </tr>

                                <tr>
                                    <td>
                                        <h5>Fecha Límite</h5>
                                        <p><?= $model->delivery_date ?></p>
                                    </td>

                                    <td style="padding-right: 25px;">

                                        <h5> Cliente</h5>
                                        <p> <?= $model->agency->name ?> </p>
                                    </td>

                                </tr>


                            </table>


                        </td>

                    </tr>
                    </tbody>
                </table>

            </td>

        </tr>

        <tr>
            <td>


                <table class="info">

                    <tr style="text-align: center">
                        <td>
                            <h5>Contenedores: <?= $model->getContainerAmount() ?> </h5>
                        </td>
                        <td class="btn">
                            <a href="<?php echo Url::to(['/rd/ticket/create','id'=>$model->id], true); ?>">Reservar Cupos</a>
                        </td>
                    </tr>

                    <tr>


                        <td style="padding-right: 25px;">

                            <?php
                            echo "<ul style=\"margin-top: 10px;\">";
                            foreach ($containers1 as $container) {
                                echo "<li>" . $container['name'] . " " . $container['code'] . " " . $container['tonnage'] . "</li>";
                            }
                            echo "</ul>";
                            ?>

                        </td>
                        <td style="padding-right: 25px;">

                            <?php
                            echo "<ul style=\"margin-top: 10px;\">";
                            foreach ($containers2 as $container) {
                                echo "<li>" . $container['name'] . " " . $container['code'] . " " . $container['tonnage'] . "</li>";
                            }
                            echo "</ul>";
                            ?>

                        </td>

                    </tr>

                    <tr style="text-align: center">
                        <td>
                            <h5>Contenedores: <?= $model->getContainerAmount() ?> </h5>
                        </td>
                        <td class="btn">
                            <a href="<?php echo Url::to(['/rd/ticket/create','id'=>$model->id], true); ?>">Reservar
                                Cupos</a>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>

</body>