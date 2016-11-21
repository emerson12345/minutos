<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Institucion
 */
class Institucion extends Model
{
    protected $table = 'institucion';

    protected $primaryKey = 'inst_id';

	public $timestamps = false;

    protected $fillable = [
        'inst_codigo',
        'inst_nombre',
        'inst_telf1',
        'inst_telf2',
        'inst_fax',
        'inst_email',
        'inst_responsable',
        'dep_id',
        'prov_id',
        'mun_id',
        'area_id',
        'inst_urbano_rural',
        'inst_nro_camas',
        'inst_localidad',
        'inst_direccion_zona',
        'inst_direccion_calle',
        'inst_seleccionable',
        'inst_fec_alta',
        'inst_fec_mod'
    ];

    protected $guarded = [];

    public function usuarios(){
        return $this->belongsToMany('Sicere\User','usuario_institucion','inst_id','user_id');
    }

    public function departamento(){
        return $this->belongsTo('Sicere\Models\LugarDepartamento','dep_id','dep_id');
    }

    public function area(){
        return $this->belongsTo('Sicere\Models\LugarArea','area_id','area_id');
    }

    public function municipio(){
        return $this->belongsTo('Sicere\Models\LugarMunicipio','mun_id','mun_id');
    }
    
    public static function get_institucion()
    {
        $instituciones = DB::table('institucion' )
            ->select('inst_codigo','inst_nombre','inst_telf1','inst_direccion_calle','dep_nombre', 'prov_nombre','mun_nombre','area_nombre')
            ->join('lugar_departamento', 'lugar_departamento.dep_id', '=', 'institucion.dep_id')
            ->join('lugar_provincia', 'lugar_provincia.prov_id', '=', 'institucion.prov_id')
            ->join('lugar_municipio', 'lugar_municipio.mun_id', '=', 'institucion.mun_id')
            ->join('lugar_area', 'lugar_area.area_id', '=', 'institucion.area_id')
            ->orderby('lugar_departamento.dep_id','lugar_municipio.mun_id')
            ->get();
        return $instituciones;
    }
}