<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

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
        'inst_frecuencia_radio',
        'inst_email',
        'inst_nit',
        'inst_direccion_calle',
        'inst_fecha_creacion',
        'inst_seleccionable',
        'inst_fec_alta',
        'inst_fec_mod',
        'dep_id',
        'prov_id',
        'mun_id',
        'inst_localidad',
        'inst_direccion_zona'
    ];

    protected $guarded = [];

        
}