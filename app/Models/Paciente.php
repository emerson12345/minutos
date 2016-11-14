<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Paciente
 */
class Paciente extends Model
{
    protected $table = 'paciente';

    protected $primaryKey = 'pac_id';

	public $timestamps = false;

    protected $fillable = [
        'pac_nro_hc',
        'pac_ap_prim',
        'pac_ap_seg',
        'pac_nombre',
        'pac_sexo',
        'pac_edad_anio',
        'pac_nro_ci',
        'pac_con_discapaci',
        'pac_seleccionable',
        'user_id',
        'inst_id'
    ];

    protected $guarded = [];

        
}