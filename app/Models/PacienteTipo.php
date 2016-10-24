<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PacienteTipo
 */
class PacienteTipo extends Model
{
    protected $table = 'paciente_tipo';

    protected $primaryKey = 'pact_id';

	public $timestamps = false;

    protected $fillable = [
        'pact_nombre',
        'pact_seleccionable',
        'pact_fec_alta',
        'pact_fec_mod'
    ];

    protected $guarded = [];

        
}