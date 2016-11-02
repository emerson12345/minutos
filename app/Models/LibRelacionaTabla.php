<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibRelacionaTabla
 */
class LibRelacionaTabla extends Model
{
    protected $table = 'lib_relaciona_tablas';

    public $timestamps = false;

    protected $fillable = [
        'rel_id',
        'lis_tabla',
        'rel_descripcion',
        'mod_codigo'
    ];

    protected $guarded = [];
}