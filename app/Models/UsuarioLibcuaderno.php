<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioInstitucion
 */
class UsuarioLibcuaderno extends Model
{
    protected $table = 'usuario_lib_cuaderno';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'cua_id'
    ];

    protected $guarded = [];

        
}