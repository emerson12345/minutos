<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Agenda
 */
class Agenda extends Model
{
    protected $table = 'agenda';

    protected $primaryKey = 'agenda_id';

	public $timestamps = false;

    protected $fillable = [
        'agenda_fec_ini',
        'agenda_fec_fin',
        'agenda_descripcion',
        'pac_id',
        'cua_id'
    ];

    protected $guarded = [];

    public function randomColor(){
        $color = [
            "#1abc9c","#2ecc71","#3498db","#9b59b6","#34495e",
            "#16a085","#27ae60","#2980b9","#8e44ad","#2c3e50",
            "#f1c40f","#e67e22","#e74c3c","#ecf0f1","#95a5a6",
            "#f39c12","#d35400","#c0392b","#bdc3c7","#7f8c8d"
        ];
        return $color[rand(0,19)];
    }

    public function paciente(){
        return $this->belongsTo('Sicere\Models\Paciente','pac_id','pac_id');
    }

    public function usuario(){
        return $this->belongsTo('Sicere\User','user_id','user_id');
    }
}