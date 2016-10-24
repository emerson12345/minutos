<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class InstitucionConvenio
 */
class InstitucionConvenio extends Model
{
    protected $table = 'institucion_convenio';

    public $timestamps = false;

    protected $fillable = [
        'inst_id',
        'conv_id'
    ];

    protected $guarded = [];

        
}