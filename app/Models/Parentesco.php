<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Parentesco
 */
class Parentesco extends Model
{
    protected $table = 'parentesco';

    protected $primaryKey = 'parent_id';

	public $timestamps = false;

    protected $fillable = [
        'parent_nombre',
        'parent_seleccionable',
        'parent_fec_alta',
        'parent_fec_mod',
        'parent_orden',
        'user_id'
    ];

    protected $guarded = [];

        
}