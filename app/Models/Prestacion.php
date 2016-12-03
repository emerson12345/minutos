<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Prestacion
 */
class Prestacion extends Model
{
    protected $table = 'prestacion';

    protected $primaryKey = 'pres_cod';

	public $timestamps = false;

    protected $fillable = [
        'FinId',
        'PrgId',
        'pres_nombre',
        'pres_costo',
        'tipo_id',
        'PreSts',
        'PreSbs',
        'gru_id',
        'TipCod',
        'NivCod'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}