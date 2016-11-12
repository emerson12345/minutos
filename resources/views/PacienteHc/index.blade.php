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
            height: 150px;
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
        <?= $listPacientes ?>
        <div id="PacienteHc">

        </div>
    </div>
    <div id="datos-paciente" class="col-md-8"></div>
    <div id="AtenccionHc" class="col-md-8">

    </div>
@stop
@section('script')
    <script>
        var url_data='{{$url_paciente}}';
        $("#t_pacientes").on('click', 'td', function(e) {
            $("#AtenccionHc").html("");
            $.ajax({
                beforeSend: function()
                {
                    console.log($("#PacienteHc").html("cargando..."));
                },
                url:url_data+"/"+e.toElement.id,
                type:"GET",
                data:{nom:"xc"},
                success: function(info){
                    //console.log(info);
                    $("#PacienteHc").html(info);
                    //console.log($("#PacienteHc").html(info));
                },
                error:function(jqXHR,estado,error){
                    console.log("errorrr2");
                    

                }
            });
        });
    </script>
@stop
