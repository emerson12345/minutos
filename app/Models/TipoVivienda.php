<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TipoVivienda
 */
class TipoVivienda extends Model
{
    protected $table = 'tipo_vivienda';

    protected $primaryKey = 'viv_id';

	public $timestamps = false;

    protected $fillable = [
        'viv_nombre',
        'viv_seleccionable',
        'viv_fec_alta',
        'viv_fec_mod'
    ];

    protected $guarded = [];

        
}