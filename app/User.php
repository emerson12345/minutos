<?php

namespace Sicere;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Sicere\Models\Rol;
use Symfony\Component\Routing\Annotation\Route;

class User extends Authenticatable
{
    const CREATED_AT = 'user_fec_alta';
    const UPDATED_AT = 'user_fec_mod';
    protected $table = 'usuario';
    protected $primaryKey = 'user_id';
    //protected $dateFormat = 'Y-m-d H:i:s';
    use Notifiable;

    protected $fillable = ['user_nombre', 'user_codigo', 'user_password', 'user_email', 'user_seleccionable'];

    protected $hidden = [
        'remember_token',
    ];

    public function setUserPasswordAttribute($value){
        $this->attributes['user_password'] = bcrypt($value);
    }

    public function getPasswordAttribute(){
        return $this->user_password;
    }

/*
        public function setCreateAtAttribute($data){
            $this->attributes['user_fec_alta'] = $data;
        }

        public function getUpdateAtAttribute(){
            return $this->user_fec_mod;
        }
        public function setUpdateAtAttribute($data){
            $this->attributes['user_fec_mod'] = $data;
        }*/

    public function roles(){
        return $this->belongsToMany('Sicere\Models\Rol','usuario_rol','user_id','rol_id');
    }

    public function instituciones(){
        return $this->belongsToMany('Sicere\Models\Institucion','usuario_institucion','user_id','inst_id');
    }
}
