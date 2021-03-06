<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarProvincium
 */
class LugarProvincia extends Model
{
    protected $table = 'lugar_provincia';

    protected $primaryKey = 'prov_id';

	public $timestamps = false;

    protected $fillable = [
        'prov_nombre',
        'prov_seleccionable',
        'prov_fec_alta',
        'prov_fec_mod',
        'dep_id'
    ];

    protected $guarded = [];

    public static function Provincias($id){
        return LugarProvincia::where('dep_id','=',$id)->pluck('prov_nombre', 'prov_id');
    }

    public function departamento(){
        return $this->belongsTo('Sicere\Models\LugarDepartamento','dep_id','dep_id');
    }
    public function municipios(){
        return $this->hasMany('Sicere\Models\LugarMunicipio','prov_id','prov_id');
    }
}