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
Route::get('prueba', 'PruebaController@show');
Route::get('pagina2', 'PruebaController@show2');
Route::resource('photos', 'PhotoController');
Route::resource('estado_civil', 'EstadoCivilController');