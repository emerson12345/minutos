<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Evolucion
 */
class Evolucion extends Model
{
    protected $table = 'evolucion';

    public $timestamps = false;

    protected $fillable = [
        'evolucion_id',
        'hc_id',
        'evolucion_descripcion'
    ];

    protected $guarded = [];
}