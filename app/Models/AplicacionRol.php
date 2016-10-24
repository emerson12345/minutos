<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AplicacionRol
 */
class AplicacionRol extends Model
{
    protected $table = 'aplicacion_rol';

    public $timestamps = false;

    protected $fillable = [
        'app_id',
        'rol_id'
    ];

    protected $guarded = [];

        
}