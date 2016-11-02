<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 */
class Rol extends Model
{
    protected $table = 'rol';

    protected $primaryKey = 'rol_id';

    public $timestamps = false;

    protected $fillable = [
        'rol_codigo',
        'rol_nombre',
        'rol_seleccionable'
    ];

    protected $guarded = [];

    public function usuarios(){
        return $this->belongsToMany('Sicere\User','usuario_rol','rol_id','user_id');
    }

    public function aplicaciones(){
        return $this->belongsToMany('Sicere\Models\Aplicacion','aplicacion_rol','rol_id','app_id');
    }
}