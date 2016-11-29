<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MunicipioConvenio
 */
class MunicipioConvenio extends Model
{
    protected $table = 'municipio_convenio';

    public $timestamps = false;

    protected $fillable = [
        'mun_id',
        'conv_id'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}