<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CuadernoEstado
 */
class CuadernoEstado extends Model
{
    protected $table = 'cuaderno_estado';

    public $timestamps = false;

    protected $fillable = [
        'cua_id',
        'fecha'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}