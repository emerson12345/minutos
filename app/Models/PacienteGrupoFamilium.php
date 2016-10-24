<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PacienteGrupoFamilium
 */
class PacienteGrupoFamilium extends Model
{
    protected $table = 'paciente_grupo_familia';

    protected $primaryKey = 'pac_id';

	public $timestamps = false;

    protected $fillable = [
        'gru_fam_id',
        'gru_fam_ap_prim',
        'gru_fam_ap_seg',
        'gru_fam_nombre',
        'gru_fam_sexo',
        'gru_fam_nro_ci',
        'gru_fam_seleccionable',
        'gru_fam_fec_alta',
        'gru_fam_fec_mod',
        'user_id'
    ];

    protected $guarded = [];

        
}