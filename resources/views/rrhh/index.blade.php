@extends('layouts.template')
@section('title')
    Personal
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Recursos humanos
@stop
@section('menu_page')
    <h1>Recursos humanos</h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>

        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-add btn-primary pull-right margin-bottom" data-url="{{route('rrhh.create')}}">
                            <i class="fa fa-plus"></i> Agregar personal
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="rrhh-table">
                            <thead>
                            <tr>
                                <th>Primer apellido</th>
                                <th>Segundo apellido</th>
                                <th>Nombres</th>
                                <th>C.I.</th>
                                <th>Sexo</th>
                                <th>Dirección</th>
                                <th>Vigente</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Personal</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary box-solid">
                        <div class="box-body">
                            Error al cargar
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    <button type="button" id="btn-save" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop
@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/datepicker/datepicker3.css')}}">
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('template/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
    <script>
    var instituteTable = $("#rrhh-table").DataTable({
        "lengthMenu": [5,10, 25, 50],
        "processing":true,
        "serverSide":true,
        "ajax": "{{route('rrhh.list')}}",
        "columns":[
            {data:'rrhh_ap_prim'},
            {data:'rrhh_ap_seg'},
            {data:'rrhh_nombre'},
            {data:'rrhh_ci'},
            {data:'rrhh_sexo'},
            {data:'rrhh_direccion_calle'},
            {
                data:function (row,type,val,meta) {
                    var valReturn = "";
                    if(row.rrhh_seleccionable == 1)
                        valReturn = "<span class='text-green'>SI</span>";
                    else
                        valReturn = "<span class='text-red'>NO</span>"
                    return valReturn;
                },
                orderable:false
            },
            {
                data:function (row,type,val,meta) {
                    return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="edit/'+row.rrhh_id+'" title="Editar"><i class="fa fa-edit"></i></button>'
                },
                orderable:false
            }
        ]
    });
    $("#rrhh-table").on('draw.dt',function () {
        $(".btn-edit").off().on('click',handleEvent);
    });

    $(".btn-add").on('click',handleEvent);

    function handleEvent(){
        var url = $(this).data("url");
        $.ajax({
            url:url,
            beforeSend:function () {
                var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
                $("#myModal").find(".box").append($over);
            },
            success:function (data) {
                $("#myModal").find(".box .box-body").html(data);
                $("#rrhh_fecha_nac").datepicker({
                    'format':'dd/mm/yyyy',
                    language:'es',
                });
            },
            complete:function () {
                $("#myModal").find(".overlay").remove();
            }
        });
        $("#myModal").modal("show");
    }

    $("#btn-save").on("click",function(){
        var $form =$(this).closest(".modal-content").find(".modal-body form");
        $.ajax({
            url:$form.attr("action"),
            data:$form.serialize(),
            method:'post',
            beforeSend:function () {
                var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
                $("#myModal").find(".box").append($over);
                $form.find("span").text("");
            },
            success:function(data){
                //alert(data);
                instituteTable.ajax.reload();
                $("#myModal").modal('hide');
            },
            error:function(data) {
                var errors = data.responseJSON;
                //alert(errors);
                $.each(errors,function(i,o){
                    $form.find("[name = '"+i+"']").closest(".col-sm-10").find("span").text(o);
                });
            },
            complete:function () {
                $("#myModal").find(".overlay").remove();
            }
        });
    });


    </script>

@stop