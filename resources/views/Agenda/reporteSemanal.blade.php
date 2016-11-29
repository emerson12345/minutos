<br><br><br><br>
<style>
    table {
        border-collapse: separate;
        padding: 10px;
        font-size: 10px;
    }
</style>
<h1>Horario Semanal</h1>
<table>
    <tr>
        <td>        Usuario:<?php echo Auth::user()->user_nombre; ?></td>
        <td>        <?php echo "Fecha de impresión: ".date('Y-m-j'); ?></td>
    </tr>
</table>
<br>
<table border="1">
<?php
    $dias=array("0"=>"Lunes","1"=>"Martes","2"=>"Miercoles","3"=>"Jueves","4"=>"Viernes");
        echo "<tr>";
        foreach($dias as $D){
            echo "<th>";
            echo $D;
            echo "</th>";
        }
        echo "</tr>";
        echo "<tr>";
        foreach($arrCalendario as $arr){
            echo "<td>";
            foreach($arr as $fila){
                echo "<br>";
                echo  substr($fila->fechaIni,11,5);
                echo  " - ".substr($fila->fechaFin,11,5);
                echo "<br>";
                echo "<span style='background-color:powderblue;'>".$fila->titulo."</span>";
                echo "<br>";
            }
            echo "</td>";
        }
        echo "</tr>";
?>
</table>
