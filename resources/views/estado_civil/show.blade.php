@extends('layouts.template')
@section('title')
    Estado Civil
@stop
@section('user')
    Manuel
@stop
@section('title_page')
    Lista de usuarios
@stop
@section('menu_page')
    <h4><a href="nuevo.html">Nuevo</a></h4>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>Inicio</a>
        </li>
        <li class="active">
            <a href="#">Estado civil</a>
        </li>
    </ol>
@stop
@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="box">
            <!--
              <div class="box-header">
                <h3 class="box-title">Pacientes registrados</h3>
              </div>
            -->
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>CI</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 4.0
                        </td>
                        <td>Win 95+</td>
                        <td> 4</td>
                        <td>
                            <a href="registro_refencia.html">Establecer Referencia</a><br>
                            <a href="registro_refencia.html">Actualizar Paciente</a><br>
                            <a href="registro_refencia.html">Eliminar Paciente</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 5.0
                        </td>
                        <td>Win 95+</td>
                        <td>5</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 5.5
                        </td>
                        <td>Win 95+</td>
                        <td>5.5</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 6
                        </td>
                        <td>Win 98+</td>
                        <td>6</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Trident</td>
                        <td>Internet Explorer 7</td>
                        <td>Win XP SP2+</td>
                        <td>7</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Trident</td>
                        <td>AOL browser (AOL desktop)</td>
                        <td>Win XP</td>
                        <td>6</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Gecko</td>
                        <td>Firefox 1.0</td>
                        <td>Win 98+ / OSX.2+</td>
                        <td>1.7</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>PSP browser</td>
                        <td>PSP</td>
                        <td>-</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>PSP browser</td>
                        <td>PSP</td>
                        <td>-</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>PSP browser</td>
                        <td>PSP</td>
                        <td>-</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    <tr>
                        <td>Other browsers</td>
                        <td>All others</td>
                        <td>-</td>
                        <td>-</td>
                        <td><a href="registro_refencia.html">Referencia</a></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>CI</th>
                        <th>Opciones</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

@stop