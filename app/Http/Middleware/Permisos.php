<?php

namespace Sicere\Http\Middleware;
use Sicere\Models\Aplicacion;
use Illuminate\Support\Facades\DB;
use Closure;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appName = $request->route()->getName();
        $app = Aplicacion::where('app_enlace_menu',$appName)->where('app_seleccionable',1)->first();
        if(!$app)
            return redirect()->route('error401');

        $user = $request->user();

        $results = DB::table('usuario_rol')
            ->join('aplicacion_rol','usuario_rol.rol_id','aplicacion_rol.rol_id')
            ->where([
                ['usuario_rol.user_id',$user->user_id],
                ['aplicacion_rol.app_id',$app->app_id]
            ])
            ->count();
        if($results < 1)
            return redirect()->route('error401');

        return $next($request);
    }
}
