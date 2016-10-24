<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EstadoCivil
 */
class EstadoCivil extends Model
{
    protected $table = 'estado_civil';

    protected $primaryKey = 'est_civ_id';

	public $timestamps = false;

    protected $fillable = [
        'est_civ_nombre',
        'est_civ_seleccionable',
        'est_civ_fec_alta',
        'est_civ_fec_mod'
    ];

    protected $guarded = [];

        
}