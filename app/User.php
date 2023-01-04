<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute() {
        return ucfirst($this->f_name) . ' ' . ucfirst($this->l_name);
    }
    public function role(){
        return $this->hasOne('\App\Role','id','role_id');
    }
    public function permissions(){
        return $this->hasMany('\App\Permission','role_id','role_id');
    }
    public function modules(){
        return $this->hasMany("\App\Module",'id','module_id');
    }

}
