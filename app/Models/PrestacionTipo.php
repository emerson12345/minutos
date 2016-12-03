<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PrestacionTipo
 */
class PrestacionTipo extends Model
{
    protected $table = 'prestacion_tipo';

    protected $primaryKey = 'tip_id';

	public $timestamps = false;

    protected $fillable = [
        'tip_nombre',
        'tip_sigla'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}