<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cif
 */
class Cif extends Model
{
    protected $table = 'cif';

    protected $primaryKey = 'cif_id';

	public $timestamps = false;

    protected $fillable = [
        'cif_cod',
        'cif_nombre',
        'cif_cla_id',
        'cif_gru_id',
        'cif_sub_id',
        'cif_seleccionable'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}