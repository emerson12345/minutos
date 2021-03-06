<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarDepartamento
 */
class LugarDepartamento extends Model
{
    protected $table = 'lugar_departamento';

    protected $primaryKey = 'dep_id';

	public $timestamps = false;

    protected $fillable = [
        'dep_nombre',
        'dep_seleccionable',
        'dep_fec_alta',
        'dep_fec_mod'
    ];

    protected $guarded = [];

    public static function listas(){
        //return LugarDepartamento::where('dep_seleccionable','=',1)->select('dep_nombre','dep_id')->get();
        $lista = LugarDepartamento::pluck('dep_nombre', 'dep_id');
        return $lista;
    }

    public function instituciones(){
        return $this->hasMany('Sicere\Models\Institucion','dep_id','dep_id');
    }
    
    public function provincias(){
        return $this->hasMany('Sicere\Models\LugarProvincia','dep_id','dep_id');
    }

    public function municipios(){
        return $this->hasManyThrough('Sicere\Models\LugarMunicipio','Sicere\Models\LugarProvincia','dep_id','prov_id','dep_id');
    }
}