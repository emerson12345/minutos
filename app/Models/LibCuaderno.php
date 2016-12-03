<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * Class LibCuaderno
 */
class LibCuaderno extends Model
{
    protected $table = 'lib_cuadernos';

    protected $primaryKey = 'cua_id';

	public $timestamps = false;

    protected $fillable = [
        'cua_nombre',
        'cua_tipo',
        'cua_fec_alta',
        'cua_fec_mod',
        'cua_seleccionable'
    ];

    protected $guarded = [];

    public function usuario(){
        return $this->belongsToMany('Sicere\User','usuario_lib_cuaderno','cua_id','user_id');
    }

    public function formulario(){
        return $this->hasMany('Sicere\Models\LibFormulario','cua_id','cua_id');
    }

    public function checkDate($date = null){
        if($this->exists && $date){
            if(DB::table('cuaderno_estado')->where('cua_id',$this->cua_id)->where('fecha',$date)->count()>0)
                return true;
        }
        return false;
    }

    public function report($fecha_ini = '01/12/2016',$fecha_fin = '01/12/2016',$edad_min = 60,$edad_max = 200,$inst_id = 0){
        if(!$this->exists)
            return [];
        $cua_id = $this->cua_id;
        return DB::select("
            select count(*) as total,
            COALESCE (sum(case WHEN sq.hc_consulta_nueva = '1' THEN 1 ELSE 0 end),0) as total_nuevo,
            COALESCE (sum(case WHEN sq.hc_consulta_nueva = '1' AND sq.pac_sexo = 'M' THEN 1 ELSE 0 end),0) as total_nuevo_masc,
            COALESCE (sum(case WHEN sq.hc_consulta_nueva = '0' THEN 1 ELSE 0 end),0) as total_repetido,
            COALESCE (sum(case WHEN sq.hc_consulta_nueva = '0' AND sq.pac_sexo = 'M' THEN 1 ELSE 0 end),0) as total_repetido_masc
            from (
                select distinct paciente_hc.*, paciente.pac_sexo  from paciente_hc
                inner join lib_registro on paciente_hc.hc_id = lib_registro.hc_id
                inner join lib_formulario on lib_registro.for_id = lib_formulario.for_id
                inner join lib_cuadernos on lib_formulario.cua_id = lib_cuadernos.cua_id
                inner join paciente on paciente.pac_id = paciente_hc.pac_id
                where (paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}')
                AND (paciente_hc.pac_edad BETWEEN {$edad_min} and {$edad_max})
                AND lib_cuadernos.cua_id = {$cua_id}
                AND paciente_hc.inst_id = {$inst_id}
            ) as sq
        ")[0];
    }
}