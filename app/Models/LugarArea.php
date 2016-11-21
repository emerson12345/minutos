<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarArea
 */
class LugarArea extends Model
{
    protected $table = 'lugar_area';

    protected $primaryKey = 'area_id';

	public $timestamps = false;

    protected $fillable = [
        'dep_id',
        'area_nombre',
        'area_direccion',
        'area_telefono',
        'area_fax',
        'area_nom_director'
    ];

    protected $guarded = [];

    public function instituciones(){
        return $this->hasMany('Sicere\Models\Institucion','area_id','area_id');
    }

    public static function Areas($id){
        return LugarArea::where('dep_id','=',$id)->pluck('area_nombre', 'area_id');
    }

}