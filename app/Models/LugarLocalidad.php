<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarLocalidad
 */
class LugarLocalidad extends Model
{
    protected $table = 'lugar_localidad';

    protected $primaryKey = 'loc_id';

	public $timestamps = false;

    protected $fillable = [
        'loc_nombre',
        'loc_seleccionable',
        'loc_fec_alta',
        'loc_fec_mod',
        'prov_id'
    ];

    protected $guarded = [];

        
}