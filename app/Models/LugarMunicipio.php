<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarMunicipio
 */
class LugarMunicipio extends Model
{
    protected $table = 'lugar_municipio';

    protected $primaryKey = 'mun_id';

	public $timestamps = false;

    protected $fillable = [
        'mun_nombre',
        'mun_anio_creacion',
        'mun_nombre_alcalde',
        'mun_seleccionable',
        'mun_fec_alta',
        'mun_fec_mod',
        'prov_id',
        'mun_codigo',
        'dep_id'
    ];

    protected $guarded = [];

        
}