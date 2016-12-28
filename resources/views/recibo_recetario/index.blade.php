@extends('layouts.template')
@section('title')
    Usuarios
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Lista de usuarios
@stop
@section('menu_page')

@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>

        </li>
    </ol>
@stop

@section('content')

<style>
    .dimension{
    height: 250px;
    overflow-x:hidden;
    overflow-y:hidden;
    }
</style>

    <div class="col-md-7">
        <section class="content">
            <h3>Recibo Recetario</h3>
            <a href="report/1">imprimir</a>
            <div class="box box-primary box-solid">
                <div class="box-body">
                    <div class="table-responsive dimension">

                        <table id="source" class="table table-bordered table-hover dimension">
                            <thead>
                            <tr>
                                <th class="tr-dimencion">Código</th>
                                <th class="tr-dimencion">Producto</th>
                                <th class="tr-dimencion">Indicaciones</th>
                                <th class="tr-cantidad">Cantidad</th>
                                <th class="tr-dimencion"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row">
                                <td  class="tr-dimencion">
                                    0
                                </td>
                                <td class="tr-dimencion">
                                    <input type="text" name="indicadores_para_el_uso" required>
                                </td>
                                <td class="tr-dimencion">
                                    <input type="text" name="indicadores_para_el_uso" required>
                                </td>
                                <td class="tr-cantidad">
                                    <input type="number" name="cantidad" class="tr-cantidad">
                                </td>
                                <td class="tr-dimencion">
                                    <input type="button" class="reciboRecetario btn btn-primary btn-xs" value="Agregar">
                                    <!--
                                    <button class="btn btn-primary btn-xs" id="btn-reciboRecetario">
                                        Agregar
                                    </button> -->
                                </td>
                            </tr>
                            <?php
                            foreach ($listFormularios as $value) {
                            ?>
                            <tr role="row">
                                <td  class="tr-dimencion" id="0">
                                    <?= $value->lis_codigo; ?>
                                </td>
                                <td class="tr-dimencion">
                                    <?= $value->lis_descripcion; ?>
                                </td>
                                <td class="tr-dimencion">
                                    <input type="text" name="indicadores_para_el_uso" class="seleccionado">
                                </td>
                                <td class="tr-cantidad">
                                    <input type="number" name="cantidad" class="tr-cantidad">
                                </td>
                                <td class="tr-dimencion">
                                    <input type="button" class="reciboRecetario btn btn-primary btn-xs" value="Agregar">
                                    <!--
                                    <button class="btn btn-primary btn-xs" id="btn-reciboRecetario">
                                        Agregar
                                    </button> -->
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.box -->
        </section><!-- /.box body -->
        <div id="Resultado">

        </div>
    </div>
    <div class="col-md-5">
        <section class="content">
            <h3>Examen Complementario</h3>
            <a href="<?= $urlRerporteExamenComplementario; ?>">imprimir</a>
            <div class="box box-primary box-solid">
                <div class="box-body">
                    <div class="table-responsive dimension">
                        <div class="row">
                            <div class='col-md-12'>
                                <label for="">Tipo de Examen: </label>
                                {!! Form::select('ec_indicadores_para_su_uso', $listExamenesTipo,true,array('name'=>'ec_indicadores_para_el_uso','id'=>'ec_indicadores_para_el_uso')) !!}
                            </div>
                            <div class="col-md-12">
                                <label for="">Examen solicitado:</label>
                                <textarea name="ec_solicitado" id="ec_solicitado" rows="3" style="margin: 0px; width: 100%; height: 60px;" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label for="">Resultado:</label>
                                <textarea name="ec_resultado" id="ec_resultado" rows="3" style="margin: 0px; width: 100%; height: 60px;" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <input type="button" value="agregar" class="btn btn-success" name="btn_ec" id="btn_ec">
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.box -->
        </section><!-- /.box body -->
        <div id="Resultado_ec">

        </div>
    </div>
@stop


@section('script')
    <script src="{{asset('js/modal/modal.js')}}"></script>
    <script src="{{asset('js/recibo_recetario/index.js')}}"></script>
    <script src="{{asset('js/tabla/tabla.js')}}"></script>
    <script src="{{asset('js/ajax/ajax.js')}}"></script>
    <script>

        var ins_med_cod="",rec_med_nombre="",rec_indicaciones="",rec_cantidad="";
        $("#source").DataTable({
            "lengthMenu": [[3, 25, 50, -1], [3, 25, 50, "All"]],
            "columnDefs": [
                {
                    "targets": [0],
                    "visible": false,
                    "searchable": true
                },
                {
                    "width": "40%",
                    "targets": [1],
                    "visible": true,
                    "searchable": true
                },
                {
                    "width": "40%",
                    "targets": [2],
                    "visible": true,
                    "searchable": true
                },
                {
                    "width": "10%",
                    "targets": [4],
                    "visible": true,
                    "searchable": false
                },
                {
                    "width": "10%",
                    "targets": [3],
                    "visible": true,
                    "searchable": true
                }
            ]
        });
        $("#btn-recibo").on('click',function() {
            alert("Recibo");
        });
        $("#source").on('click', '.reciboRecetario', function(e){
            var x=1;
            $(this).parents("tr").find("td").each(function(){
                switch(x){
                    /*
                     case 0:
                     ins_med_cod = $(this).html().trim();
                     if(ins_med_cod=="")
                     ins_med_cod=-1;
                     break;*/
                    case 1:
                        //console.log($(this).find("textarea"));
                        //console.log($(this).children("textarea").val());
                        if($(this).find("input").is("input"))
                            rec_med_nombre=$(this).find("input").val();
                        else
                        {
                            rec_med_nombre = $(this).html().trim();
                            if(rec_med_nombre=="")
                                rec_med_nombre=-1;
                        }
                        rec_med_nombre=rec_med_nombre.replace("/","-");
                        rec_med_nombre=rec_med_nombre.replace("%","_");
                        $(this).find("input").val("");
                        break;
                    case 2:
                        rec_indicaciones=$(this).find("input").val().trim();
                        if(rec_indicaciones=="")
                            rec_indicaciones=-1;
                        $(this).find("input").val("");
                        break;
                    case 3:
                        rec_cantidad=$(this).find("input").val().trim();
                        if(rec_cantidad=="")
                            rec_cantidad=-1;
                        $(this).find("input").val("");
                        break;
                }
                x=x+1;
            });
            var urlReciboRecetario='{{$urlreciboRecetario}}';
            ins_med_cod="B";
            ajaxGET("#Resultado",urlReciboRecetario+'/'+ins_med_cod.replace("/","-")+"/"+rec_indicaciones.replace("/","-")+"/"+rec_cantidad+"/"+rec_med_nombre);
        });
        $("#btn_ec").on('click',function(e)
        {
            var ec_indicador,ec_resultado;
            ec_indicador=$("#ec_indicadores_para_el_uso").val();
            ec_resultado=$("#ec_resultado").val();
            ec_solicitado=$("#ec_solicitado").val();
            if(ec_resultado=="")
                ec_resultado=-1;
            if(ec_solicitado=="")
                ec_solicitado=-1;
            $("#ec_resultado").val("");
            $("#ec_solicitado").val("");

            var urlexamencomplementario='{{$urlexamencomplementario}}';
            ajaxGET("#Resultado_ec",urlexamencomplementario+'/'+ec_indicador+"/"+ec_resultado+"/"+ec_solicitado);
        });
    </script>
@stop