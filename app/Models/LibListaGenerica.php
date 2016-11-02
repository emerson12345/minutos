<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibListaGenerica
 */
class LibListaGenerica extends Model
{
    protected $table = 'lib_lista_generica';

    public $timestamps = false;

    protected $fillable = [
        'lis_tabla',
        'lis_codigo',
        'lis_descripcion',
        'emp_codigo',
        'lis_sigla',
        'vgrucodigo',
        'vsercodigo',
        'lis_gen_pend'
    ];

    protected $guarded = [];

}