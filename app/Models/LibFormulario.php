<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LibFormulario
 */
class LibFormulario extends Model
{
    protected $table = 'lib_formulario';

    protected $primaryKey = 'for_id';

	public $timestamps = false;



    protected $fillable = [
        'cua_id',
        'col_id',
        'for_col_posi',
        'for_seleccionable',
        'for_obliga',
        'for_modifica'
    ];
  
    protected $guarded = [];

    public function cuaderno(){
        return $this->belongsTo('Sicere\Models\LibCuaderno','cua_id','cua_id');
    }

    public function columna(){
        return $this->belongsTo('Sicere\Models\LibColumna','col_id','col_id');
    }


}