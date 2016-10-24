<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 */
class Rol extends Model
{
    protected $table = 'rol';

    protected $primaryKey = 'rol_id';

	public $timestamps = false;

    protected $fillable = [
        'rol_codigo',
        'rol_nombre',
        'rol_seleccionable',
        'rol_fec_alta',
        'rol_fec_mod',
        'sistema_id'
    ];

    protected $guarded = [];

        
}