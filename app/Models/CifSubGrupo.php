<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CifSubGrupo
 */
class CifSubGrupo extends Model
{
    protected $table = 'cif_sub_grupo';

    protected $primaryKey = 'cif_sub_id';

	public $timestamps = false;

    protected $fillable = [
        'cif_sub_cod',
        'cif_sub_nombre',
        'cif_cla_id',
        'cif_gru_id'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}