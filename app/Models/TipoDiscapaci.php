<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoDiscapaci
 */
class TipoDiscapaci extends Model
{
    protected $table = 'tipo_discapaci';

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