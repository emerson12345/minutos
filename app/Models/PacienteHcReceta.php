<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PacienteHcRecetum
 */
class PacienteHcReceta extends Model
{
    protected $table = 'paciente_hc_receta';

    protected $primaryKey = 'rec_id';

	public $timestamps = false;

    protected $fillable = [
        'hc_id',
        'ins_med_cod',
        'rec_med_nombre',
        'rec_indicaciones',
        'rec_cantidad',
        'rec_fec_alta',
        'user_id'
    ];
}