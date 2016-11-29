<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Evolucion
 */
class VistaPacienteNombres extends Model
{
    protected $table = 'v_paciente_nombres';

    public $timestamps = false;

    protected $guarded = [];
}
