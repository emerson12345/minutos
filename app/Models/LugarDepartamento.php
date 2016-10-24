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

        
}