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
/*
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
Route::get('prueba', 'PruebaController@show');
Route::group(['prefix'=>'usuario','middleware'=>['auth']],function(){
    Route::get('index','UsuarioController@index')->name('usuario.index');
    Route::get('users','UsuarioController@users')->name('usuario.list');
    Route::get('create','UsuarioController@create')->name('usuario.create');
    Route::post('store','UsuarioController@store')->name('usuario.store');
    Route::get('edit/{idUser}','UsuarioController@edit')->name('usuario.edit');
    Route::post('update/{idUser}','UsuarioController@update')->name('usuario.update');
});

Route::group(['prefix'=>'rol'],function(){
    Route::get('index','RolController@index')->name('rol.index');
    Route::get('roles','RolController@roles')->name('rol.list');
    Route::get('create','RolController@create')->name('rol.create');
    Route::get('edit/{idRol}','RolController@edit')->name('rol.edit');
    Route::post('create','RolController@store')->name('rol.create.store');
    Route::post('edit/{idRol}','RolController@store')->name('rol.edit.store');
});

Route::get('error401',function(){
    return view('errors.401');
})->middleware('auth')->name('error401');

$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');