<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function userInfo(){
        return $this->hasOne(UserInfo::class,'id','id');
    }

    public function getRoleAttribute(){
        return 'admin';
    }

    public function getAllPermissionsAttribute(){
        $permisos = [];
        
        foreach($this->getAllPermissions() as $permiso){
            $permiso=[
                'action'=> $permiso->name,
                'subject' => 'all'
            ];
            $permisos[]= $permiso;
        }

        return $permisos;
    }

    /**
     * Devuelve la URL completa del avatar del usuario
     */
    public function getAvatarURLAttribute(){
        return asset('images/profiles/'.($this->avatar? $this->avatar:'avatar.png'));
    }
}
