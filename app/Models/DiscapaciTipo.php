<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DiscapaciTipo
 */
class DiscapaciTipo extends Model
{
    protected $table = 'discapaci_tipo';

    protected $primaryKey = 'tipo_disc_id';

	public $timestamps = false;

    protected $fillable = [
        'tipo_disc_nombre',
        'tipo_disc_seleccionable',
        'tipo_disc_fec_alta',
        'tipo_disc_fec_mod'
    ];

    protected $guarded = [];

}