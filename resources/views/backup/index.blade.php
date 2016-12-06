@extends('layouts.template')
@section('title')
    Cuadernos
@stop
@section('user')

@stop
@section('title_page')
    Backup de seguridad
@stop
@section('menu_page')
        <h1>Copia de seguridad</h1>
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
                        <input type="button" id="btn_backup" value="Generar copia de seguridad">
                    </div>
                    <div class="col-md-12" id="respuesta">

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop


@section('script')
    <script src="{{asset('js/ajax/ajax.js')}}"></script>
    <script>
        $("#btn_backup").on('click',function(e)
        {
            var urlBackup='{{$urlBackup}}';
            ajaxGET("#respuesta",urlBackup);
        });
    </script>
@stop