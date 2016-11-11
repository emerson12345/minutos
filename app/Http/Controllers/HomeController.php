<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }
}
