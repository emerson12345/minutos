<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibColumna
 */
class LibColumna extends Model
{
    protected $table = 'lib_columnas';

    protected $primaryKey = 'col_id';

	public $timestamps = false;

    protected $fillable = [
        'col_combre',
        'col_tipo',
        'col_ran_val_ini',
        'col_ran_val_fin',
        'col_ancho',
        'rel_id',
        'col_seleccionable',
        'col_fec_alta',
        'col_fec_mod'
    ];

    protected $guarded = [];
}