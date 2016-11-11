<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibCuaderno
 */
class LibCuaderno extends Model
{
    protected $table = 'lib_cuadernos';

    protected $primaryKey = 'cua_id';

	public $timestamps = false;

    protected $fillable = [
        'cua_nombre',
        'cua_tipo',
        'cua_fec_alta',
        'cua_fec_mod',
        'cua_seleccionable'
    ];

    protected $guarded = [];

    public function formulario(){
        return $this->hasMany('Sicere\Models\LibFormulario','cua_id','cua_id');
    }
}