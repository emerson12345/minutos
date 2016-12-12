<style>
    .centrar
    {
        position: absolute;
        /*nos posicionamos en el centro del navegador*/
        top:50%;
        left:50%;
        /*determinamos una anchura*/
        width:400px;
        /*indicamos que el margen izquierdo, es la mitad de la anchura*/
        margin-left:-200px;
        /*determinamos una altura*/
        height:300px;
        /*indicamos que el margen superior, es la mitad de la altura*/
        margin-top:-150px;
        border:0px solid #808080;
        padding:5px;
    }
</style>
<?php
$total=0;
$total_alta_temporal=0;
$total_alta_definitiva=0;
?>
<br>
<div>
    <table class="centrar" style="border: none">
        <tr>
            <td>Fecha Inicio:{{$fecha_ini}}</td>
            <td>Fecha Fin:{{$fecha_fin}}</td>
        </tr>
    </table>
    <table border="1" class="centrar">
        <tr style="background-color: #34495e;color: white;">
            <th>TECNICA DE TRATAMIENTO</th>
            <th style="text-align: center">ALTA TEMPORAL</th>
            <th style="text-align: center">ALTA DEFINITIVA</th>
        </tr>
        @foreach ($list_tratamiento_realizado as $value)
            <tr>
                <td style="font-weight: bold;color: #34495e;">{{$value->cua_nombre}}</td>
                <td style="text-align: center;font-weight: normal;">{{$value->alta_temporal}}</td>
                <td style="text-align: center;font-weight: normal;">{{$value->alta_definitiva}}</td>
                <?php
                $total_alta_definitiva=$total_alta_definitiva+$value->alta_temporal;
                $total_alta_temporal=$total_alta_temporal+$value->alta_definitiva;
                ?>
            </tr>
        @endforeach
        <tr style="background-color: red;color: white;">
            <td style="font-weight: bold;">TOTAL</td>
            <td style="text-align: center;font-weight:  bold;">{{$total_alta_definitiva}}</td>
            <td style="text-align: center;font-weight:  bold;">{{$total_alta_temporal}}</td>
        </tr>
    </table>
</div>