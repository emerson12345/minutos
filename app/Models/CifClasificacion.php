<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CifClasificacion
 */
class CifClasificacion extends Model
{
    protected $table = 'cif_clasificacion';

    protected $primaryKey = 'cif_cla_id';

	public $timestamps = false;

    protected $fillable = [
        'cif_cla_cod',
        'cif_cla_nombre'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}