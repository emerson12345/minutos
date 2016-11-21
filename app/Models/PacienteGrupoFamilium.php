<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PacienteGrupoFamilium
 */
class PacienteGrupoFamilium extends Model
{
    protected $table = 'paciente_grupo_familia';

    protected $primaryKey = 'gru_fam_id';

	public $timestamps = false;

    protected $fillable = [
        'pac_id',
        'gru_fam_ap_prim',
        'gru_fam_ap_seg',
        'gru_fam_nombre',
        'gru_fam_sexo',
        'gru_fam_nro_ci',
        'gru_fam_telf',
        'gru_fam_direccion',
        'gru_fam_seleccionable',
        'user_id',
        'parent_id'
    ];

    protected $guarded = [];

    public function parentesco(){
        return $this->belongsTo('Sicere\Models\Parentesco','parent_id','parent_id');
    }
}