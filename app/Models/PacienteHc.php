<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PacienteHc
 */
class PacienteHc extends Model
{
    protected $table = 'paciente_hc';

    protected $primaryKey = 'hc_id';

	public $timestamps = false;

    protected $fillable = [
        'pac_id',
        'pac_edad',
        'hc_fecha',
        'hc_nro_orden',
        'rrhh_id',
        'pact_id',
        'conv_id',
        'cuaderno_id',
        'hc_consulta_nueva',
        'hc_consulta_dentro',
        'hc_con_seguro',
        'hc_fec_alta',
        'hc_fec_mod',
        'user_id',
        'inst_id'
    ];

    protected $guarded = [];
}