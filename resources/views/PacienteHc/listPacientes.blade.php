<?php
$fecha_de_nacimiento = "1948-05-11";
$fecha_actual = date ("Y-m-d");
//$fecha_actual = date ("2006-03-05"); //para pruebas
function EdadCompleta($fecha_de_nacimiento)
{
    $fecha_actual=date("Y-m-d");
    $array_nacimiento = explode ( "-", $fecha_de_nacimiento);
    $array_actual = explode ( "-", $fecha_actual );

    $anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
    $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
    $dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

    //ajuste de posible negativo en $días
    if ($dias < 0)
    {
        --$meses;

        //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
        switch ($array_actual[1]) {
            case 1:     $dias_mes_anterior=31; break;
            case 2:     $dias_mes_anterior=31; break;
            case 3:
                if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
            case 4:     $dias_mes_anterior=31; break;
            case 5:     $dias_mes_anterior=30; break;
            case 6:     $dias_mes_anterior=31; break;
            case 7:     $dias_mes_anterior=30; break;
            case 8:     $dias_mes_anterior=31; break;
            case 9:     $dias_mes_anterior=31; break;
            case 10:     $dias_mes_anterior=30; break;
            case 11:     $dias_mes_anterior=31; break;
            case 12:     $dias_mes_anterior=30; break;
        }

        $dias=$dias + $dias_mes_anterior;
    }

    //ajuste de posible negativo en $meses
    if ($meses < 0)
    {
        --$anos;
        $meses=$meses + 12;
    }

    echo "$anos/$meses/$dias";
}
function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
    if (checkdate(2,29,$anio_actual))
    {
        $bisiesto=true;
    }
    return $bisiesto;
}
?>
<div class="box">
    <div class="box-body" >
        <div class="box-title">
            <h3>Pacientes</h3>
        </div>
        <table class="table table-bordered" id="t_pacientes">
            <thead>
            <tr>
                <th class="tr-dimencion-title">HC</th>
                <th class="tr-dimencion-title">Nombre</th>
                <th class="tr-dimencion-title">Edad(AA,MM,DD)</th>
                <th class="tr-dimencion-title">CI</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($listPacientes as $flight) {
            ?>
            <tr class="tr-cuadernos">
                <td id="<?= $flight->pac_id ?>" class="tr-dimencion" style="width:59px">
                    <?= $flight->pac_nro_hc ?>
                </td>
                <td id="<?= $flight->pac_id ?>" class="tr-dimencion" style="width:90px">
                    <?= $flight->pac_nombre ?><br>
                    <?= $flight->pac_ap_prim ?><br>
                    <?= $flight->pac_ap_seg ?><br>
                </td>
                <td id="<?= $flight->pac_id ?>" class="tr-dimencion" style="width:130px">
                    <?= EdadCompleta($flight->pac_fecha_nac); ?>
                </td>
                <td id="<?= $flight->pac_id ?>" class="tr-dimencion" style="width:0px">
                    <?= $flight->pac_nro_ci ?>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>