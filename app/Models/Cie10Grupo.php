<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cie10Grupo
 */
class Cie10Grupo extends Model
{
    protected $table = 'cie10_grupo';

    protected $primaryKey = 'cieg_id';

	public $timestamps = false;

    protected $fillable = [
        'cieg_cod',
        'cieg_nombre',
        'cieg_seleccionable',
        'cieg_fec_alta',
        'cieg_fec_mod',
        'user_id'
    ];

    protected $guarded = [];

        
}