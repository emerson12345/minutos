<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DiscapaciGrado
 */
class DiscapaciGrado extends Model
{
    protected $table = 'discapaci_grado';

    protected $primaryKey = 'grad_disc_id';

	public $timestamps = false;

    protected $fillable = [
        'grad_disc_nombre',
        'grad_disc_seleccionable',
        'grad_disc_fec_alta',
        'grad_disc_fec_mod'
    ];

    protected $guarded = [];

}