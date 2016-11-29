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

<<<<<<< Updated upstream
	public $timestamps = false;

    protected $fillable = [
        'agenda_fec_ini',
        'agenda_fec_fin',
        'agenda_descripcion',
        'rrhh_id',
        'pac_id'
    ];

    protected $guarded = [];

    public function randomColor(){
        $r = rand(0,15);
        $g = rand(0,15);
        $b = rand(0,15);
        return "rgb({$r},{$g},{$b})";
    }
=======
    public $timestamps = false;

    protected $fillable = [
        'agenda_fec_ini',
        'rrhh_id',
        'pac_id',
        'inst_id',
        'agenda_estado',
        'agenda_fec_fin',
        'agenda_todo_dia',
        'agenda_color',
        'agenda_descripcion'
    ];

    protected $guarded = [];
>>>>>>> Stashed changes
}