<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamenesTipo
 */
class ExamenesTipo extends Model
{
    protected $table = 'examenes_tipo';

    protected $primaryKey = 'exc_tip_id';

	public $timestamps = false;

    protected $fillable = [
        'exc_tip_nombre',
        'exc_tip_seleccionable',
        'exc_tip_fec_alta',
        'exc_tip_fec_mod'
    ];
    protected $guarded = [];
}