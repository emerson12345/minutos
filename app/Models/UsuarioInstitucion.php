<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsuarioInstitucion
 */
class UsuarioInstitucion extends Model
{
    protected $table = 'usuario_institucion';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'inst_id'
    ];

    protected $guarded = [];

        
}