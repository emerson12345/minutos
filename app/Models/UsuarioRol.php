<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioRol
 */
class UsuarioRol extends Model
{
    protected $table = 'usuario_rol';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'rol_id'
    ];

    protected $guarded = [];

        
}