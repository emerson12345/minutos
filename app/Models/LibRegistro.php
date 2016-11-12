<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibRegistro
 */
class LibRegistro extends Model
{
    protected $table = 'lib_registro';

    public $timestamps = false;

    protected $fillable = [
        'hc_id',
        'for_id',
        'reg_dato',
        'red_descripcion'
    ];

    protected $guarded = [];
}