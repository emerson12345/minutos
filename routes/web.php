<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', 'HomeController@index')->middleware(['auth','access']);

/***Rutas de pedro ***/
Route::group(['prefix'=>'usuario','middleware'=>['auth','access','log']],function(){
    Route::get('index','UsuarioController@index')->name('adm.usuario.index');
    Route::get('usuarios','UsuarioController@usuarios')->name('adm.usuario.list');
    Route::get('create','UsuarioController@create')->name('adm.usuario.create');
    Route::post('store','UsuarioController@store')->name('adm.usuario.store');
    Route::get('update/{user_id}','UsuarioController@update')->name('adm.usuario.update');
    Route::post('edit/{user_id}','UsuarioController@edit')->name('adm.usuario.edit');
    Route::get('report','UsuarioController@report')->name('adm.usuario.report');
    Route::get('password','UsuarioController@password')->name('adm.usuario.password');
    Route::post('update_password','UsuarioController@update_password')->name('adm.usuario.update_password');
    Route::get('permiso_cuaderno/{user_id}','UsuarioController@permiso_cuaderno')->name('adm.usuario.permiso_cuaderno');
    Route::post('set_cuaderno/{user_id}','UsuarioController@set_cuaderno')->name('adm.usuario.set_cuaderno');
    Route::get('usuario/rrhh','UsuarioController@rrhh')->name('adm.usuario.rrhh');
});

Route::group(['prefix'=>'rol','middleware'=>['auth','access','log']],function(){
    Route::get('index','RolController@index')->name('adm.rol.index');
    Route::get('roles','RolController@roles')->name('adm.rol.list');
    Route::get('create','RolController@create')->name('adm.rol.create');
    Route::post('create','RolController@store')->name('adm.rol.store');
    Route::get('update/{rol_id}','RolController@edit')->name('adm.rol.update');
    Route::post('update/{rol_id}','RolController@store')->name('adm.rol.edit');
});

Route::get('error401',function(){
    return view('errors.401');
})->middleware('auth')->name('error401');

/***poner estas rutas en log*/
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('login.post');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
$this->get('account_init','Auth\InitController@accountInit')->name('account.init');
$this->post('account_init','Auth\InitController@accountInitPost')->name('account.init.post');


Route::group(['prefix'=>'cuaderno','middleware'=>['auth','access','log']],function(){
    Route::get('index','LibCuadernoController@index')->name('cuaderno.index');
    Route::get('peticion/{id}','LibCuadernoController@peticion')->name('cuaderno.peticion');
    Route::get('peticion_listas/{intIDColumna}','LibCuadernoController@peticionListas')->name('cuaderno.peticionListas');
});

/***Rutas de emerson ***/
Route::group(['prefix'=>'institucion','middleware'=>['auth','access','log']],function(){
    Route::get('index','InstitucionController@index')->name('institucion.index');
    Route::get('institucion','InstitucionController@institucion')->name('institucion.list');
    Route::get('create','InstitucionController@create')->name('institucion.create');
    Route::post('create','InstitucionController@store')->name('institucion.create.store');
    Route::get('edit/{idInst}','InstitucionController@edit')->name('institucion.edit');
    Route::post('edit/{idInst}','InstitucionController@store')->name('institucion.edit.store');
    Route::get('report','InstitucionController@report')->name('institucion.report');
});
Route::group(['prefix'=>'rrhh','middleware'=>['auth','access','log']],function(){
    Route::get('index','RrhhController@index')->name('rrhh.index');
    Route::get('rrhh','RrhhController@rrhh')->name('rrhh.list');
    Route::get('create','RrhhController@create')->name('rrhh.create');
    Route::post('create','RrhhController@store')->name('rrhh.create.store');
    Route::get('edit/{idRrhh}','RrhhController@edit')->name('rrhh.edit');
    Route::post('edit/{idRrhh}','RrhhController@store')->name('rrhh.edit.store');
});

Route::group(['prefix'=>'permiso','middleware'=>['auth','access','log']],function(){
    Route::get('index','UsuarioController@all_permisos')->name('adm.permiso.index');
    Route::get('list','UsuarioController@all_users')->name('adm.permiso.list');
    Route::get('establecimiento/{user_id}','UsuarioController@permiso_establecimiento')->name('adm.permiso.establecimiento');
    Route::post('set_establecimiento/{user_id}','UsuarioController@set_establecimiento')->name('adm.permiso.set_establecimiento');
});

/***Rutas de percy***/
Route::group(['prefix'=>'adm_cuaderno','middleware'=>['auth','access','log']],function(){
    Route::get('index','CuadernoController@index')->name('adm.cuaderno.index');
    Route::get('cuadernos','CuadernoController@cuadernos')->name('adm.cuaderno.list');
    Route::get('create','CuadernoController@create')->name('adm.cuaderno.create');
    Route::post('create','CuadernoController@store')->name('adm.cuaderno.store');
    Route::get('update/{cua_id}','CuadernoController@update')->name('adm.cuaderno.update');
    Route::post('update/{cua_id}','CuadernoController@store')->name('adm.cuaderno.edit');
});

Route::group(['prefix'=>'cuaderno','middleware'=>['auth','access','log']],function(){
    Route::get('index','LibCuadernoController@index')->name('cuaderno.index');
    Route::get('peticion/{cua_id}/{pac_id}','LibCuadernoController@peticion')->name('cuaderno.peticion');
    Route::get('peticion_listas/{intIDColumna}/{for_id}/{col_tipo}','LibCuadernoController@peticionListas')->name('cuaderno.peticionListas');
    Route::get('detalle/{hc_id}/{cua_id}','LibCuadernoController@detalle')->name('cuaderno.detalle');
});

Route::group(['prefix'=>'PacienteHc','middleware'=>['auth','access','log']],function(){
    Route::get('index','PacienteHcController@index')->name('PacienteHc.index');
    Route::get('historial_clinico/{id}','PacienteHcController@registroHistoricoPaciente')->name('PacienteHc.registroHistoricoPaciente');
    Route::get('buscar_historial_clinico/{fecha_inicio}/{fecha_fin}/{cua_id}/{rrhh_id}/{pac_id}','PacienteHcController@searchHc')->name('PacienteHc.searchHc');
    Route::get('atencion/{cua_id}/{pac_id}/{hc_id}/{fecha}','PacienteHcController@atencionHc')->name('PacienteHc.atencion');
    //Route::get('agenda','PacienteHcController@agenda')->name('PacienteHc.agenda');
});

//Eventos Calendario
Route::group(['prefix'=>'Agenda','middleware'=>['auth','access','log']],function(){
    Route::get('home','FullcalendareventoController@home')->name('Agenda.home');
    //Route::get('index','FullcalendareventoController@index')->name('Agenda.index');
    Route::get('cargaEventos{id?}','FullcalendareventoController@index')->name('fullcalendar.index');
    Route::post('guardaEventos', array('as' => 'guardaEventos','uses' => 'FullcalendareventoController@create'));
    Route::post('actualizaEventos','FullcalendareventoController@update');
    Route::post('eliminaEvento','FullcalendareventoController@delete');
    Route::get('reporte/{fecha_inicio}','FullcalendareventoController@reporteSemanal')->name('Agenda.reporte');
});

Route::group(['prefix'=>'libregistro','middleware'=>['auth','access','log']],function(){
    Route::get('index','LibRegistroController@index')->name('libregistro.index');
    Route::post('store','LibRegistroController@store')->name('libregistro.store');
    Route::post('edit','LibRegistroController@edit')->name('libregistro.edit');
});

Route::group(['prefix'=>'paciente','middleware'=>['auth','access','log']],function(){
    Route::get('index','PacienteController@index')->name('adm.paciente.index');
    Route::get('pacientes','PacienteController@pacientes')->name('adm.paciente.list');
    Route::get('create','PacienteController@create')->name('adm.paciente.create');
    Route::post('create','PacienteController@store')->name('adm.paciente.store');
    Route::get('update/{pac_id}','PacienteController@update')->name('adm.paciente.update');
    Route::post('update/{pac_id}','PacienteController@store')->name('adm.paciente.edit');
    Route::get('detail/{pac_id}','PacienteController@detail')->name('adm.paciente.detail');
    Route::get('group/{pac_id}','PacienteController@group')->name('adm.paciente.group');
    Route::get('group/{pac_id}/create','PacienteController@formGroup')->name('adm.paciente.group.create');
    Route::get('group/{pac_id}/update/{group_id}','PacienteController@formGroup')->name('adm.paciente.group.update');
    Route::post('group/{pac_id}/create','PacienteController@storeGroup')->name('adm.paciente.group.store');
    Route::post('group/{pac_id}/update/{group_id}','PacienteController@storeGroup')->name('adm.paciente.group.edit');
    Route::get('report/{pac_id}','PacienteController@report')->name('adm.paciente.report');
});

/***Rutas de parámetros de sistema****/
Route::group(['prefix'=>'parametro','middleware'=>['auth','access','log']],function(){
    Route::get('index','ParametrosController@index')->name('parametro.index');
    Route::get('cuaderno/estado','CuadernoController@estado')->name('cuaderno.estado');
    Route::post('cuaderno/estado','CuadernoController@setData')->name('cuaderno.setData');
    Route::post('cuaderno/getData','CuadernoController@getData')->name('cuaderno.getData');
    Route::get('setup','ParametrosController@setup')->name('parametro.setup');
    Route::post('update','ParametrosController@update')->name('parametro.update');
});

Route::group(['prefix'=>'convenio','middleware'=>['auth','access','log']],function(){
    Route::get('index','ConvenioController@index')->name('adm.convenio.index');
    Route::get('convenios','ConvenioController@convenios')->name('adm.convenio.list');
    Route::get('create','ConvenioController@create')->name('adm.convenio.create');
    Route::get('update/{conv_id}','ConvenioController@update')->name('adm.convenio.update');
    Route::post('create','ConvenioController@store')->name('adm.convenio.store');
    Route::post('update/{conv_id}','ConvenioController@store')->name('adm.convenio.edit');
});

Route::group(['prefix'=>'agenda','middleware'=>['auth','access','log']],function(){
    Route::get('temporal/index','AgendaController@index')->name('agenda.temporal.index');
    Route::get('create','AgendaController@create')->name('agenda.create');
    Route::post('create','AgendaController@store')->name('agenda.store');
    Route::get('getPaciente','AgendaController@pacientes')->name('agenda.pacientes');
    Route::get('getMedico','AgendaController@medicos')->name('agenda.medicos');
});
/**Agrupar estas rutas dentro de agenda**/
Route::get('agenda/view','AgendaController@view')->name('agenda.view');
Route::post('agenda/events','AgendaController@getEvents')->name('agenda.events');

/***Poner estas rutas dentro de auth**/
Route::get('/provincia/getprovincia', ['uses' => 'LugarProvinciaController@getprovincia','as' => 'provincia.getprovincia']);
Route::get('/municipio/getmunicipio', ['uses' => 'LugarMunicipioController@getmunicipio','as' => 'municipio.getmunicipio']);
Route::get('/area/getarea', ['uses' => 'LugarAreaController@getarea','as' => 'area.getarea']);
Route::post('municipios','PacienteController@getMunicipios')->name('get.municipios');




/********Rutas para reportes**********/

Route::get('reporte/produccion','ReporteController@produccion')->name('reporte.produccion');
Route::post('reporte/produccion','Reportecontroller@produccionPDF')->name('reporte.produccion.pdf');
Route::get('agenda/agenda','AgendaController@agenda')->name('agenda.agenda');
Route::post('agenda/getAgenda','AgendaController@getAgenda')->name('agenda.agenda.get');
Route::post('agenda/change','AgendaController@change')->name('agenda.change');

Route::get('reporte/inasistencia','ReporteAgendaController@inasistencia')->name('reporte.agenda.inasistencia');
Route::post('reporte/inasistencia','ReporteAgendaController@postInasistencia')->name('reporte.agenda.inasistencia.post');
Route::get('reporte/abandonos','ReporteAgendaController@abandonos')->name('reporte.agenda.abandonos');
Route::post('reporte/abandonos','ReporteAgendaController@postAbandonos')->name('reporte.agenda.abandonos.post');
Route::get('reporte/exitosos','ReporteAgendaController@tratamientosExitosos')->name('reporte.agenda.exitosos');
Route::post('reporte/exitosos','ReporteAgendaController@postTratamientosExitosos')->name('reporte.agenda.exitosos.post');
Route::get('reporte/etario','ReporteAgendaController@grupoEtario')->name('reporte.agenda.etario');
Route::post('reporte/etario','ReporteAgendaController@postgrupoEtario')->name('reporte.agenda.etario.post');
Route::post('reporte/getCuadernos','ReporteAgendaController@getCuadernos')->name('reporte.agenda.cuadernos');