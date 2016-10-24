<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RrhhTipo
 */
class RrhhTipo extends Model
{
    protected $table = 'rrhh_tipo';

    protected $primaryKey = 'rrhh_tipo_id';

	public $timestamps = false;

    protected $fillable = [
        'rrhh_tipo_nombre',
        'rrhh_tipo_seleccionable',
        'rrhh_tipo_fec_alta',
        'rrhh_tipo_fec_mod'
    ];

    protected $guarded = [];

        
}