<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\LugarArea;
class LugarAreaController extends Controller
{
    //
    public function getarea(Request $request)
    {
        return LugarArea::where('dep_id', $request->dep_id)->pluck('area_nombre', 'area_id');
        //return $request->dep_id;
    }
}
