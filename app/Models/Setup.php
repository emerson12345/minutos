<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setup
 */
class Setup extends Model
{
    protected $table = 'setup';

    protected $primaryKey = 'set_id';

	public $timestamps = false;

    protected $fillable = [
        'set_descripcion',
        'set_valor',
        'set_fec_alta',
        'set_fec_mod'
    ];

    protected $guarded = [];
    

}