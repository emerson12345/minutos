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
        .tr-dimencion{
            width: 200px;
        }
        .td-dimencion{
            width: 200px;
        }
        .tr-seleccionable{
            background-color: #e74c3c;
        }
        .tr-seleccionable-hc{
            background-color: #e67e22;
        }
    </style>
    <!------------------------------------------------>

    <!------------------------------------------------>




    <div class="col-xs-5">
        <?= $listPacientes ?>
        <div id="PacienteHc">


        </div>
    </div>
    <div id="datos-paciente" class="col-md-5"></div>
    <div id="AtenccionHc" class="col-md-7">

    </div>
@stop
@section('script')
    <script>
        var url_data='{{$url_paciente}}';
        var fila_seleccinable_pacientes;
        $("#t_pacientes").on('click', 'td', function(e) {
            $("#AtenccionHc").html("");
                if (typeof fila_seleccinable_pacientes == 'undefined') {
                    $(this).parent().addClass("tr-seleccionable");
                    fila_seleccinable_pacientes=$(this);
                }
                else
                {
                    fila_seleccinable_pacientes.parent().removeClass("tr-seleccionable");
                    $(this).parent().addClass("tr-seleccionable");
                    fila_seleccinable_pacientes=$(this);
                }
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
        $(function () {
            //alert("adfa");
            $("#t_pacientes").DataTable();
            /*$('#t_pacientes').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });*/
        });
    </script>
@stop
