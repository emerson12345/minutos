<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PlanDomiciliario
 */
class PlanDomiciliario extends Model
{
    protected $table = 'plan_domiciliario';

    public $timestamps = false;

    protected $fillable = [
        'pac_id',
        'fecha',
        'fecha_revision',
        'familiar_seg_id',
        'persona_ref_id',
        'areas_trabajo',
        'que',
        'como',
        'quien',
        'tiempo',
        'logros_fecha'
    ];

    protected $guarded = [];
}