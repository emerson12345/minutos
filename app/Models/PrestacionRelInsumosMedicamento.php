<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PrestacionRelInsumosMedicamento
 */
class PrestacionRelInsumosMedicamento extends Model
{
    protected $table = 'prestacion_rel_insumos_medicamentos';

    public $timestamps = false;

    protected $fillable = [
        'pres_cod',
        'ins_med_cod',
        'FinId',
        'PrgId'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}