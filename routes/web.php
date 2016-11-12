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

Route::get('/', function () {
    return view('welcome');
});
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
Route::get('prueba', 'PruebaController@show');
Route::get('pagina2', 'PruebaController@show2');
Route::resource('photos', 'PhotoController');
Route::resource('estado_civil', 'EstadoCivilController');
*/
Route::group(['prefix'=>'usuario','middleware'=>'log'],function(){
    Route::get('index','UsuarioController@index')->name('usuario.index');
    Route::get('create','UsuarioController@create')->name('usuario.create');
    Route::post('store','UsuarioController@store')->name('usuario.store');
    Route::get('edit/{idUser}','UsuarioController@edit')->name('usuario.edit');
    Route::post('update/{idUser}','UsuarioController@update')->name('usuario.update');
});

Route::group(['prefix'=>'rol'],function(){
    Route::get('index','RolController@index')->name('rol.index');
    Route::get('create','RolController@create')->name('rol.create');
    Route::get('edit/{idRol}','RolController@edit')->name('rol.edit');
    Route::post('create','RolController@store')->name('rol.create.store');
    Route::post('edit/{idRol}','RolController@store')->name('rol.edit.store');
});

Route::group(['prefix'=>'cuaderno'],function(){
    Route::get('index','LibCuadernoController@index')->name('cuaderno.index');
    Route::get('peticion/{id}','LibCuadernoController@peticion')->name('cuaderno.peticion');
    Route::get('peticion_listas/{intIDColumna}','LibCuadernoController@peticionListas')->name('cuaderno.peticionListas');
    Route::get('detalle/{hc_id}/{cua_id}','LibCuadernoController@detalle')->name('cuaderno.detalle');
});

Route::group(['prefix'=>'libregistro'],function(){
    Route::get('index','LibRegistroController@index')->name('libregistro.index');
    Route::post('store','LibRegistroController@store')->name('libregistro.store');
});

Route::group(['prefix'=>'PacienteHc'],function(){
    Route::get('index','PacienteHcController@index')->name('PacienteHc.index');
    Route::get('historial_clinico/{id}','PacienteHcController@registroHistoricoPaciente')->name('PacienteHc.registroHistoricoPaciente');
    Route::get('atencion/{cua_id}/{hc_id}/{fecha}','PacienteHcController@atencionHc')->name('PacienteHc.atencion');
});