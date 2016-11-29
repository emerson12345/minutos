<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LugarProvincium
 */
class LugarProvincium extends Model
{
    protected $table = 'lugar_provincia';

    protected $primaryKey = 'prov_id';

	public $timestamps = false;

    protected $fillable = [
        'dep_id',
        'prov_nombre',
        'prov_seleccionable',
        'prov_fec_alta',
        'prov_fec_mod'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}