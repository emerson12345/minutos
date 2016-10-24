<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ocupacion
 */
class Ocupacion extends Model
{
    protected $table = 'ocupacion';

    protected $primaryKey = 'ocu_id';

	public $timestamps = false;

    protected $fillable = [
        'ocu_nombre',
        'ocu_seleccionable',
        'ocu_fec_alta',
        'ocu_fec_mod'
    ];

    protected $guarded = [];

        
}