<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarMunicipioArea
 */
class LugarMunicipioArea extends Model
{
    protected $table = 'lugar_municipio_area';

    public $timestamps = false;

    protected $fillable = [
        'mun_id',
        'area_id'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}