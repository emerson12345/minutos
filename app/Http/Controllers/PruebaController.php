<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;

class PruebaController extends Controller
{
    function show()
    {
        return view('prueba');
    }
    function show2()
    {
        return view('pagina2');
    }
}
