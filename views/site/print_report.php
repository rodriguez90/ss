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

    <h3 style="text-align: center">Reporte </h3>

    <?php
    foreach ($process as $p){
        echo "<h5>".$p->type."</h5>";
    }
    ?>




</div>

</body>
</html>

