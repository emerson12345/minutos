<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CifGrupo
 */
class CifGrupo extends Model
{
    protected $table = 'cif_grupo';

    protected $primaryKey = 'cif_gru_id';

	public $timestamps = false;

    protected $fillable = [
        'cif_gru_cod',
        'cif_gru_nombre',
        'cif_cla_id'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}