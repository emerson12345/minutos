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
/*
Route::get('prueba',function(){
    return "Hola desde laravel";
});
Route::get('persona/{nombre}',function($nombre){
    return "Buenos dias ".$nombre;
});
Route::get('persona/{nombre}',function($nombre){
    return "Buenos dias ".$nombre;
});*/
/*
Route::get('pagina2', 'PruebaController@show2');
Route::resource('photos', 'PhotoController');
Route::resource('estado_civil', 'EstadoCivilController');
*/
Route::group(['prefix'=>'usuario','middleware'=>['auth','access']],function(){
    Route::get('index','UsuarioController@index')->name('adm.usuario.index');
    Route::get('usuarios','UsuarioController@usuarios')->name('adm.usuario.list');
    Route::get('create','UsuarioController@create')->name('adm.usuario.create');
    Route::post('store','UsuarioController@store')->name('adm.usuario.store');
    Route::get('update/{user_id}','UsuarioController@update')->name('adm.usuario.update');
    Route::post('edit/{user_id}','UsuarioController@edit')->name('adm.usuario.edit');
    Route::get('report','UsuarioController@report')->name('adm.usuario.report');
});
Route::group(['prefix'=>'rol'],function(){
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
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('login.post');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');
$this->get('account_init','Auth\InitController@accountInit')->name('account.init');
$this->post('account_init','Auth\InitController@accountInitPost')->name('account.init.post');
Route::group(['prefix'=>'cuaderno'],function(){
    Route::get('index','LibCuadernoController@index')->name('cuaderno.index');
    Route::get('peticion/{id}','LibCuadernoController@peticion')->name('cuaderno.peticion');
    Route::get('peticion_listas/{intIDColumna}','LibCuadernoController@peticionListas')->name('cuaderno.peticionListas');
});
Route::group(['prefix'=>'institucion','middleware'=>'log'],function(){
    Route::get('index','InstitucionController@index')->name('institucion.index');
    Route::get('create','InstitucionController@create')->name('institucion.create');
    Route::post('store','InstitucionController@store')->name('institucion.store');
    Route::get('edit/{idInst}','InstitucionController@edit')->name('institucion.edit');
    Route::post('update/{idInst}','InstitucionController@update')->name('institucion.update');
});
//Route::get('provincia/{id}','LugarProvinciaController@getprovincia');
Route::get('/provincia/getprovincia', ['uses' => 'LugarProvinciaController@getprovincia','as' => 'provincia.getprovincia']);
Route::get('/municipio/getmunicipio', ['uses' => 'LugarMunicipioController@getmunicipio','as' => 'municipio.getmunicipio']);
Route::group(['prefix'=>'adm_cuaderno'],function(){
    Route::get('index','CuadernoController@index')->name('adm.cuaderno.index');
    Route::get('cuadernos','CuadernoController@cuadernos')->name('adm.cuaderno.list');
    Route::get('create','CuadernoController@create')->name('adm.cuaderno.create');
    Route::post('create','CuadernoController@store')->name('adm.cuaderno.store');
    Route::get('update/{cua_id}','CuadernoController@update')->name('adm.cuaderno.update');
    Route::post('update/{cua_id}','CuadernoController@store')->name('adm.cuaderno.edit');
});
Route::group(['prefix'=>'cuaderno'],function(){
    Route::get('index','LibCuadernoController@index')->name('cuaderno.index');
    Route::get('peticion/{id}','LibCuadernoController@peticion')->name('cuaderno.peticion');
    Route::get('peticion_listas/{intIDColumna}','LibCuadernoController@peticionListas')->name('cuaderno.peticionListas');
    Route::get('detalle/{hc_id}/{cua_id}','LibCuadernoController@detalle')->name('cuaderno.detalle');
});

Route::group(['prefix'=>'PacienteHc'],function(){
    Route::get('index','PacienteHcController@index')->name('PacienteHc.index');
    Route::get('historial_clinico/{id}','PacienteHcController@registroHistoricoPaciente')->name('PacienteHc.registroHistoricoPaciente');
    Route::get('atencion/{cua_id}/{hc_id}/{fecha}','PacienteHcController@atencionHc')->name('PacienteHc.atencion');
});

Route::group(['prefix'=>'libregistro'],function(){
    Route::get('index','LibRegistroController@index')->name('libregistro.index');
    Route::post('store','LibRegistroController@store')->name('libregistro.store');
});