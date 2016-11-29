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
        'pac_fecha_nac',
        'pac_edad_anio',
        'pac_nro_ci',
        'pac_con_discapaci',
        'pac_seleccionable',
        'user_id',
        'inst_id',
        'exp_id',
        'tipo_disc_id',
        'grad_disc_id',
        'est_civ_id',
        'pac_ocupacion',
        'pac_comunidad',
        'pac_direccion',
        'pac_nro_telf',
        'dep_id',
        'mun_id'
    ];

    protected $guarded = [];

    public function grupoFamiliar(){
        return $this->hasMany('Sicere\Models\PacienteGrupoFamilium','pac_id','pac_id');
    }

    public function getNombreCompletoAttribute(){
        return $this->pac_nombre.' '.$this->pac_ap_prim.' '.$this->pac_ap_seg;
    }

    public function expedido(){
        return $this->belongsTo('Sicere\Models\CiExpedido','exp_id','exp_id');
    }

    public function tipoDiscapacidad(){
        return $this->belongsTo('Sicere\Models\DiscapaciTipo','tipo_disc_id','tipo_disc_id');
    }

    public function gradoDiscapacidad(){
        return $this->belongsTo('Sicere\Models\DiscapaciGrado','grad_disc_id','grad_disc_id');
    }

    public function estadoCivil(){
        return $this->belongsTo('Sicere\Models\EstadoCivil','est_civ_id','est_civ_id');
    }

    public function departamento(){
        return $this->belongsTo('Sicere\Models\LugarDepartamento','dep_id','dep_id');
    }

    public function municipio(){
        return $this->belongsTo('Sicere\Models\LugarMunicipio','mun_id','mun_id');
    }

    public function getNextHC(){
        $next_id = \DB::select("select nextval('agenda_agenda_id_seq')");
        return $next_id[0]->nextval;
    }
}