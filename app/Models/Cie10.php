<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cie10
 */
class Cie10 extends Model
{
    protected $table = 'cie10';

    protected $primaryKey = 'cie_id';

	public $timestamps = false;

    protected $fillable = [
        'cie_cod',
        'cie_nombre',
        'cie_seleccionable',
        'cie_fec_alta',
        'cie_fec_mod',
        'user_id',
        'cieg_id'
    ];

    protected $guarded = [];

        
}