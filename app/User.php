<?php

namespace Sicere;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    const CREATED_AT = 'user_fec_alta';
    const UPDATED_AT = 'user_fec_mod';
    protected $table = 'usuario';
    protected $primaryKey = 'user_id';

    use Notifiable;

    protected $dateFormat = 'd/m/Y H:i:s';
    protected $guarded = ['_token','user_password2'];

    protected $hidden = [
        'remember_token',
    ];

    public function setUserPasswordAttribute($value){
        $this->attributes['user_password'] = bcrypt($value);
    }

    public function getRules(){
        return [
            'user_nombre' => 'required',
            'user_codigo' => 'required',
            'user_password' => 'required',
            'user_email' => 'email',
            'user_seleccionable' => 'boolean'
        ];
    }

    public function messages(){
        return [
            'required' => 'este campo es requerido'
        ];
    }
}
