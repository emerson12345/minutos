<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InsumosMedicamento
 */
class InsumosMedicamento extends Model
{
    protected $table = 'insumos_medicamentos';

    protected $primaryKey = 'ins_med_cod';

	public $timestamps = false;

    protected $fillable = [
        'ins_med_nombre',
        'ins_med_forma',
        'ins_med_concentracion',
        'ins_med_tipo',
        'ins_med_costo',
        'ins_med_nivel'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}