<?php

namespace Sicere\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CiExpedido
 */
class CiExpedido extends Model
{
    protected $table = 'ci_expedido';

    protected $primaryKey = 'exp_id';

	public $timestamps = false;

    protected $fillable = [
        'exp_nombre'
    ];

    protected $guarded = [];

}