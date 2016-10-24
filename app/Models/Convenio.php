<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Convenio
 */
class Convenio extends Model
{
    protected $table = 'convenio';

    protected $primaryKey = 'conv_id';

	public $timestamps = false;

    protected $fillable = [
        'conv_nombre',
        'conv_seleccionable',
        'conv_fec_alta',
        'conv_fec_mod'
    ];

    protected $guarded = [];

        
}