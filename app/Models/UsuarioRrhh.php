<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioRrhh
 */
class UsuarioRrhh extends Model
{
    protected $table = 'usuario_rrhh';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'rrhh_id'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}