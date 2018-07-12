<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>

    <image src="<?php echo $path ?>"></image>



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

</div>
