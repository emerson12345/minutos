<?php

namespace Sicere;

use Illuminate\Database\Eloquent\Model;

class Fullcalendarevento extends Model
{
    protected $table = 'fullcalendareventos';
    protected $fillable = ['fechaIni','fechaFin','todoeldia','lugar','color','titulo'];
    protected $hidden = ['id'];
    //
}
