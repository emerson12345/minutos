<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 */
class Usuario extends Model
{
    protected $table = 'usuario';

    protected $primaryKey = 'user_id';

	public $timestamps = false;

    protected $fillable = [
        'user_codigo',
        'user_nombre',
        'user_password',
        'user_email',
        'user_seleccionable',
        'user_fec_alta',
        'user_fec_mod',
        'inst_nombre',
        'user_alta_confirmada',
        'user_cargo',
        'user_razon_solicitud'
    ];

    protected $guarded = [];

        
}