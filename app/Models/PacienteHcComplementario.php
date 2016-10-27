<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PacienteHcComplementario
 */
class PacienteHcComplementario extends Model
{
    protected $table = 'paciente_hc_complementario';

    protected $primaryKey = 'hc_id';

	public $timestamps = false;

    protected $fillable = [
        'exc_tip_id',
        'hc_com_solicitud',
        'hc_com_fecha',
        'hc_com_resultado',
        'hc_com_fec_alta',
        'hc_com_fec_mod',
        'user_id'
    ];

    protected $guarded = [];

        
}