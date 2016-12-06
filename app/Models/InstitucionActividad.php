<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InstitucionActividad
 */
class InstitucionActividad extends Model
{
    protected $table = 'institucion_actividad';

    protected $primaryKey = 'act_id';

	public $timestamps = false;

    protected $fillable = [
        'inst_id',
        'user_id',
        'act_nro',
        'act_fecha',
        'act_apellido_nombre',
        'act_nro_educativas_familia',
        'act_nro_comunidad',
        'act_nro_cai',
        'act_nro_cai_os',
        'act_nro_comite_salud',
        'act_nro_supervision',
        'act_nro_auditoria',
        'act_nro_educativas_salud',
        'act_seleccionable',
        'act_fec_alta',
        'act_fec_mod'
    ];

    protected $guarded = [];


}