<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\CanResetPassword;

use Laravel\Passport\HasApiTokens;


use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'avatar',
        'estado',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'role',
        'creado'
    ];

    public function userInfo(){
        return $this->hasOne(UserInfo::class,'id','id');
    }

    /**
     * Devuel el nombre del primer rol del Usuario
     */
    public function getRoleAttribute(){
        if($this->roles()->count()>0){
            return $this->roles()->first()->name;
        }
        return 'Sin rol';
    }

    /**
     * Devuelve todos los permisos del usuario
     */
    public function getAllPermissionsAttribute(){
        $permisos = [];
        
        foreach($this->getAllPermissions() as $permiso){
            $p = explode('-',$permiso->name);
            if(count($p)==2){
                $permiso=[
                    'action'=> $p[0],
                    'subject' => $p[1]
                ];
                $permisos[]= $permiso;
            }
        }
        return $permisos;
    }

    /**
     * Devuelve la URL completa del avatar del usuario
     */
    public function getAvatarURLAttribute(){
        return asset('images/profiles/'.($this->avatar? $this->avatar:'avatar.png'));
    }

    /**
     * Devuelve la fecha de creación del usaurio
     */
    public function getCreadoAttribute(){
        return $this->created_at->format('M, d Y');
    }
}
