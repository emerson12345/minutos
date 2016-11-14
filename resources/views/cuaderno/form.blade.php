@extends('layouts.template')
@section('title')
    Cuadernos
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Crear/Editar
@stop
@section('menu_page')
    <h1>Cuadernos <small>{{ !$cuaderno->exists?'Nuevo':'Editar'}}</small></h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('adm.cuaderno.index')}}">Usuarios</a>
        </li>
        <li>
            {{ !$cuaderno->exists?'Nuevo':'Editar'}}
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            {!! Form::model($cuaderno,['class'=>'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('cua_nombre', 'NOMBRE CUADERNO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('cua_nombre',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('cua_seleccionable', 'ESTADO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        Vigente
                        {!! Form::radio('cua_seleccionable','1',true) !!}
                        No vigente
                        {!! Form::radio('cua_seleccionable','0') !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Agregar</button>
                    @if(!$cuaderno->exists)
                    <button type="button" id="btn-remove-row" class="btn btn-default btn-xs"><i class="fa fa-minus"></i> Eliminar</button>
                    @endif
                    <button type="button" id="btn-up-row" class="btn btn-default btn-xs"><i class="fa fa-arrow-up"></i> Subir</button>
                    <button type="button" id="btn-down-row" class="btn btn-default btn-xs"><i class="fa fa-arrow-down"></i> Bajar</button>
                </div>

                <table class="table table-bordered table-striped table-condensed" id="table-items-selected">
                    <thead>
                    <tr>
                        <th width="5%">Posi</th>
                        <th width="80%">Nombre</th>
                        <th width="5%">Sel</th>
                        <th width="5%">Obliga.</th>
                        <th width="5%">Modi.</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1;?>
                        @foreach($formulario as $col)
                            <tr data-id="<?php echo $col->columna->col_id;?>">
                                <td>{{$index}}</td>
                                <td>{{$col->columna->col_combre}}</td>
                                <td>
                                    <input type="hidden" name="lib_formulario[{{$index}}][for_id]" value="{{$col->for_id}}">
                                    <input type="hidden" name="lib_formulario[{{$index}}][col_id]" value="{{$col->col_id}}">
                                    <input type="hidden" name="lib_formulario[{{$index}}][for_col_posi]" value="{{$index}}">
                                    <input type="hidden" name="lib_formulario[{{$index}}][for_seleccionable]" value="0" >
                                    <input type="checkbox" name="lib_formulario[{{$index}}][for_seleccionable]" value="1" {{  $col->for_seleccionable?'checked':'' }}>
                                </td>
                                <td>
                                    <input type="hidden" name="lib_formulario[{{$index}}][for_obliga]" value="N">
                                    <input type="checkbox" name="lib_formulario[{{$index}}][for_obliga]" value="S" {{  $col->for_obliga=='S'?'checked':'' }}>
                                </td>
                                <td>
                                    <input type="hidden" name="lib_formulario[{{$index}}][for_modifica]" value="N">
                                    <input type="checkbox" name="lib_formulario[{{$index}}][for_modifica]" value="S" {{  $col->for_modifica=='S'?'checked':'' }}>
                                </td>
                            </tr>
                            <?php $index++?>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo cuaderno</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary box-solid">
                        <div class="box-body">
                            <table id="table-list-columns" class="table table-bordered table-condensed table-striped">
                                <thead>
                                <th>Nombre</th>
                                </thead>
                                <tbody>
                                @foreach(\Sicere\Models\LibColumna::where('col_seleccionable',1)->get() as $column)
                                    <tr data-id="{{$column->col_id}}">
                                        <td>{{$column->col_combre}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btn-add-column"><i class="fa fa-check"></i> Seleccionar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <style>
        #table-list-columns tbody tr,#table-items-selected tbody tr{
            cursor: pointer;
        }
        #table-list-columns tbody tr.item-selected,#table-items-selected tbody tr.item-selected{
            background: #357ca5;
            color: #FFF;
        }
        #table-list-columns tbody tr.item-unselected{
            color: grey;
            cursor: not-allowed;
        }
    </style>
@stop

@section('script')
    <script src="{{asset('js/cuaderno/form.js')}}"></script>
@stop