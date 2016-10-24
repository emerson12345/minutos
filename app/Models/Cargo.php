<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cargo
 */
class Cargo extends Model
{
    protected $table = 'cargos';

    protected $primaryKey = 'car_id';

	public $timestamps = false;

    protected $fillable = [
        'car_nombre',
        'car_orden',
        'car_seleccionable',
        'car_fec_alta',
        'car_fec_mod',
        'user_id'
    ];

    protected $guarded = [];

        
}