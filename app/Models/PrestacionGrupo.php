<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PrestacionGrupo
 */
class PrestacionGrupo extends Model
{
    protected $table = 'prestacion_grupo';

    protected $primaryKey = 'gru_id';

	public $timestamps = false;

    protected $fillable = [
        'gru_nombre',
        'gru_codigo',
        'gru_fec_alta',
        'gru_fec_mod'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}