
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
        {!! Form::open(['route' => 'libregistro.store' ,'class'=>'form-horizontal']) !!}
            <div class="col-md-4">
                <input type="submit" class="btn btn-success">
                <div class="box">
                    <div class="box-body" >
                        <table class="table table-bordered" id="t_Rrhh">
                            <tbody>
                            <tr>
                                <th>Rrhh</th>
                            </tr>
                            <?php
                            foreach ($listRrhh as $flight) {
                            ?>
                            <tr class="tr-cuadernos">
                                <td id="<?= $flight->rrhh_id ?>" class="<?= $flight->rrhh_id ?>">
                                    <?= $flight->rrhh_nombre ?>
                                    <?= $flight->rrhh_ap_prim ?>
                                    <?= $flight->rrhh_ap_seg ?>

                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box">
                    <div class="box-body" >
                        <table class="table table-bordered" id="t_pacientes">
                            <tbody>
                            <tr>
                                <th>PACIENTES</th>
                            </tr>
                            <?php
                            foreach ($listPacientes as $flight) {
                            ?>
                            <tr class="tr-cuadernos">
                                <td id="<?= $flight->pac_id ?>">
                                    <?= $flight->pac_nombre ?>
                                    <?= $flight->pac_ap_prim ?>
                                    <?= $flight->pac_ap_seg ?>

                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

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
            <div id="datos-rhh" class="col-md-8"></div>
            <div id="datos-paciente" class="col-md-8"></div>



            <div id="cuaderno" class="col-md-8">

            </div>

        <?php
        $arrdatos=array("nombre"=>"nombres","apellido"=>"apellidos");
        $_POST['arrdatos']=$arrdatos;
        ?>
        {{ Form::hidden('rrhh_id', 'secret', array('id' => 'rrhh_id')) }}
        {{ Form::hidden('pac_id', 'secret', array('id' => 'pac_id')) }}

        {!! Form::close() !!}
    @stop
@section('script')
    <script>
        var url_data='{{$url_cuaderno}}';
        ajax_cuaderno(url_data,"#t_cuadernos","#cuaderno",'click',"GET");
        /*
        $("#t_cuadernos").on('click', 'td', function(e) {
            var url_cuaderno='{{$url_cuaderno}}';
            $.ajax({
                    beforeSend: function()
                    {
                        console.log($("#cuaderno").html("cargando..."));
                    },
                    url:url_cuaderno+"/"+e.toElement.id,
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
        });*/
        $("#t_Rrhh").on('click', 'td', function(e) {
            //console.log($("#datos").html("cargando..."));
            //console.log(e.toElement.id);
            //console.log(e.toElement);
            //console.log($(this).html());
            //'rrhh_id',e.toElement.id); ?>
            $("#datos-rhh").html("<b>Rhh: </b> "+$(this).html());
            $("#rrhh_id").val(e.toElement.id);
            //console.log($("#rrhh_id").val());
            //console.log($("#cuaderno").html(e.toElement.id));
        });
        $("#t_pacientes").on('click', 'td', function(e) {
            //console.log($("#datos-paciente").html("cargando..."));
            //console.log(e.toElement.id);
            //console.log(e.toElement);
            //console.log($(this).html());
            //'pac_id',e.toElement.id); ?>
            $("#pac_id").val(e.toElement.id);
            $("#datos-paciente").html("<b>Paciente: </b> "+$(this).html());
            //console.log($("#pac_id").val());
            //console.log($("#cuaderno").html(e.toElement.id));
        });
    </script>
@stop