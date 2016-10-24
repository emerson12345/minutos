<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aplicacion
 */
class Aplicacion extends Model
{
    protected $table = 'aplicacion';

    protected $primaryKey = 'app_id';

	public $timestamps = false;

    protected $fillable = [
        'app_id_padre',
        'app_nivel_menu',
        'app_nombre',
        'app_enlace_menu',
        'app_seleccionable',
        'sistema_id',
        'app_fec_alta',
        'app_orden'
    ];

    protected $guarded = [];

        
}