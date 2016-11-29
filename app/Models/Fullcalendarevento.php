<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Fullcalendarevento
 */
class Fullcalendarevento extends Model
{
    protected $table = 'fullcalendareventos';

    public $timestamps = true;

    protected $fillable = [
        'fechaIni',
        'fechaFin',
        'todoeldia',
        'color',
        'titulo'
    ];

    protected $guarded = [];

    {{getters}}

    {{setters}}


}