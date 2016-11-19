<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Convenio
 */
class Convenio extends Model
{
    protected $table = 'convenio';

    protected $primaryKey = 'conv_id';

	public $timestamps = false;

    protected $fillable = [
        'conv_nombre',
        'conv_codigo',
        'conv_seleccionable',
        'conv_niv_nacional',
    ];

    protected $guarded = [];

    public function municipios(){
        return $this->belongsToMany('Sicere\Models\LugarMunicipio','municipio_convenio','conv_id','mun_id');
    }
        
}