<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rrhh
 */
class Rrhh extends Model
{
    protected $table = 'rrhh';

    protected $primaryKey = 'rrhh_id';

	public $timestamps = false;

    protected $fillable = [
        'rrhh_ci',
        'rrhh_ap_prim',
        'rrhh_ap_seg',
        'rrhh_nombre',
        'rrhh_fecha_nac',
        'rrhh_sexo',
        'rrhh_direccion_calle',
        'rrhh_telf_celular',
        'rrhh_email',
        'prof_id',
        'rrhh_tipo_id',
        'inst_id',
        'rrhh_seleccionable',
        'rrhh_fec_alta',
        'rrhh_fec_mod',
        'user_id'
    ];

    protected $guarded = [];

        
}