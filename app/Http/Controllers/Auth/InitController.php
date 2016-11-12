<?php

namespace Sicere\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\Institucion;

class InitController extends Controller
{
    public function accountInit(){
        return view('auth.accountInit');
    }
    
    public function accountInitPost(Request $request){
        $institucion = Institucion::find($request->selectCenter);
        session(['institucion'=>$institucion]);
        return redirect('/');
    }
}
