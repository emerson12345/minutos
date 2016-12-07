<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
/**
 * Class InstitucionActividad
 */
class InstitucionActividad extends Model
{
    protected $table = 'institucion_actividad';

    protected $primaryKey = 'act_id';

	public $timestamps = false;

    protected $fillable = [
        'inst_id',
        'user_id',
        'act_nro',
        'act_fecha',
        'act_apellido_nombre',
        'act_nro_educativas_familia',
        'act_nro_comunidad',
        'act_nro_cai',
        'act_nro_cai_os',
        'act_nro_comite_salud',
        'act_nro_supervision',
        'act_nro_auditoria',
        'act_nro_educativas_salud',
        'act_seleccionable'
    ];

    protected $guarded = [];

    public function max_nro_orden(){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $max_nro = DB::select("select 
          COALESCE(max(act_nro),0) as max_act_nro 
          from institucion_actividad where inst_id={$inst_id}")[0]->max_act_nro;
        return $max_nro;
    }

}