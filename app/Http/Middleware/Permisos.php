<?php

namespace Sicere\Http\Middleware;
use Sicere\Models\Aplicacion;
use Illuminate\Support\Facades\DB;
use Closure;
use Sicere\User;

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
        $user = $request->user();
        if(!session()->has('institucion')){
            if($user->instituciones()->count()==1)
                session(['institucion'=>$user->instituciones()->first()]);
            else
                return redirect()->route('account.init');
        }
        if(!session()->has('menu')){
            session(['menu'=>$this->getMenu()]);
        }
        $appName = $request->route()->getName();

        if(!$appName)
            return $next($request);

        $app = Aplicacion::where('app_enlace_menu',$appName)->where('app_seleccionable',1)->first();
        if(!$app)
            return redirect()->route('error401');
        if($app->app_renderiza == 0){
            if(!$app->app_padre)
                return redirect()->route('error401');
            $app = $app->app_padre;
        }

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

    private function getMenu(){
        $menu = [];
        if(\Auth::check()){
            $usuario = User::with('roles.aplicaciones')->find(\Auth::user()->user_id);
            foreach ($usuario->roles as $rol){
                foreach ($rol->aplicaciones as $app){
                    $app_parent = $app->app_padre;
                    if($app_parent){
                        $menu[$app_parent->app_id]['label']= $app_parent->app_nombre;
                        $temp = ['label'=>$app->app_nombre, 'url' => $app->app_enlace_menu];
                        $menu[$app_parent->app_id]['items'][$app->app_id] = $temp;
                    }
                }
            }
        }
        return $menu;
    }
}
