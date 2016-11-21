@extends('layouts.template')
@section('title')
    Instituciones
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Lista de instituciones
@stop
@section('menu_page')
    <h1>Instituciones <small>lista</small></h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('institucion.index')}}">Instituciones</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('institucion.report')}}" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        <button type="button" class="btn btn-add btn-primary pull-right margin-bottom" data-url="{{route('institucion.create')}}">
                            <i class="fa fa-plus"></i> Agregar intitución
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="institucion-table">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>E-mail</th>
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
                    <h4 class="modal-title">Nueva institución</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary box-solid">
                        <div class="box-body">
                            The body of the box
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
    <script>
    var instituteTable = $("#institucion-table").DataTable({
        "lengthMenu": [5,10, 25, 50],
        "processing":true,
        "serverSide":true,
        "ajax": "{{route('institucion.list')}}",
        "columns":[
            {data:'inst_codigo'},
            {data:'inst_nombre'},
            {data:'inst_telf1'},
            {data:'inst_email'},
            {data:'inst_direccion_calle'},
            {
                data:function (row,type,val,meta) {
                    var valReturn = "";
                    if(row.inst_seleccionable == 1)
                        valReturn = "<span class='label label-primary'>SI</span>";
                    else
                        valReturn = "<span class='label label-danger'>NO</span>"
                    return valReturn;
                },
                orderable:false
            },
            {
                data:function (row,type,val,meta) {
                    return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="edit/'+row.inst_id+'"><i class="fa fa-edit"></i> Editar</button>'
                },
                orderable:false
            }
        ]
    });
    $("#institucion-table").on('draw.dt',function () {
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
            },
            complete:function () {
                $("#myModal").find(".overlay").remove();
            }
        });
        $("#myModal").modal("show");
    }

    $("#btn-save").on("click",function(){
        var $form =$(this).closest(".modal-content").find(".modal-body form");
        //alert($form);
        //alert($form.attr("action"));
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