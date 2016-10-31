@extends('layouts.template')
@section('title')
    Cuadernos
@stop
@section('user')
    Manuel
@stop
@section('title_page')
    Cuadernos
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>Inicio</a>
        </li>
        <li class="active">
            <a href="#">Cuadernos</a>
        </li>
    </ol>
    @stop
    @section('content')
        <style>
            thead, tbody { display: block; }
            tbody {
                height: 450px;
                overflow-y: auto;
                overflow-x: hidden;
            }
            .tr-cuadernos:hover
            {
                background-color: #1abc9c;
                cursor: pointer;
            }
        </style>
        <div class="col-md-4">
            <div class="box">
                <div class="box-body" >
                    <table class="table table-bordered" id="t_cuadernos">
                        <tbody>
                            <tr>
                                <th>CUADERNOS</th>
                            </tr>
                            <?php
                            foreach ($listCuadernos as $flight) {
                            ?>
                            <tr class="tr-cuadernos">
                                <td id="<?= $flight->cua_id ?>">
                                    <?= $flight->cua_nombre ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="cuaderno" class="col-md-6">

        </div>
    @stop
@section('script')
    <script>

        $("#t_cuadernos").on('click', 'td', function(e) {
            $.ajax({
                    beforeSend: function()
                    {
                        console.log($("#cuaderno").html("cargando..."));
                    },
                    url:"http://localhost:8000/cuaderno/peticion/"+e.toElement.id,
                    type:"GET",
                    data:{nom:"xc"},
                    success: function(info){
                        console.log(info);
                        console.log($("#cuaderno").html(info));
                    },
                    error:function(jqXHR,estado,error){
                        console.log("errorrr");

                    }
            });
            console.log(e.toElement.id);
            //console.log($("#cuaderno").html(e.toElement.id));
        });
    </script>
@stop