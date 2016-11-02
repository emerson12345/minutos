<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibFormulario
 */
class LibFormulario extends Model
{
    protected $table = 'lib_formulario';

    protected $primaryKey = 'for_id';

	public $timestamps = false;

    protected $fillable = [
        'for_fecha',
        'cua_id',
        'col_id',
        'for_col_posi',
        'for_seleccionable',
        'for_ver',
        'grs_codigo',
        'for_val_grs',
        'for_vel_def',
        'for_obliga',
        'for_modifica',
        'for_formato',
        'for_cursiva'
    ];

    protected $guarded = [];
}