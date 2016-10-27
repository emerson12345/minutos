<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profesione
 */
class Profesione extends Model
{
    protected $table = 'profesiones';

    protected $primaryKey = 'prof_id';

	public $timestamps = false;

    protected $fillable = [
        'prof_nombre',
        'prof_seleccionable',
        'prof_fec_alta',
        'prof_fec_mod',
        'user_id'
    ];

    protected $guarded = [];

        
}