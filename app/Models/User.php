<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

use Optix\Media\HasMedia;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasRoles, HasFactory, HasMedia, Notifiable;

    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'cedula',
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
        'fullName',
        'role',
        'creado',
        'avatarURL'
    ];

    //Estados disponibles para el enum 'estado'
    public const STATUS_PENDIENTE = "pendiente";
    public const STATUS_ACTIVO = "activo";
    public const STATUS_INACTIVO = "inactivo";

    /**
     * Registro de conversiones a distintos tamaños
     *  para imagenes asignadas a este modelo
     */
    public function registerMediaGroups()
    {
        $this->addMediaGroup('main')
            ->performConversions('thumb', 'preview', 'square');

        $this->addMediaGroup('portada')
            ->performConversions('thumb', 'preview', 'square');

        $this->addMediaGroup('galeria')
            ->performConversions('preview', 'square');
    }

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = route('password.reset', ['token' => $token, 'email' => $this->email]);

        $this->notify(new ResetPasswordNotification($url));
    }

    /**
     * Devuelve la información complementaria de un usuario
     */
    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'id', 'id');
    }

    /**
     * Devuel el nombre del primer rol del Usuario
     */
    public function getRoleAttribute()
    {
        if ($this->roles()->count() > 0) {
            return $this->roles()->first()->name;
        }
        return 'Sin rol';
    }

    /**
     * Devuelve todos los permisos del usuario
     */
    public function getAllPermissionsAttribute()
    {
        $permisos = [];

        foreach ($this->getAllPermissions() as $permiso) {
            $p = explode('-', $permiso->name);
            if (count($p) == 2) {
                $permiso = [
                    'action' => $p[0],
                    'subject' => $p[1]
                ];
                $permisos[] = $permiso;
            }
        }
        return $permisos;
    }

    /**
     * Devuelve la URL completa del avatar del usuario
     */
    public function getAvatarURLAttribute()
    {
        return $this->getFirstMediaUrl('main', 'preview')
            ? $this->getFirstMediaUrl('main', 'preview')
            : asset('images/profiles/no-image.png');
    }

    /**
     * Devuelve la URL completa de la imagen del productor en el formato requerido
     */
    public function scopeImageURL($query, $collection = "default", $type = "")
    {
        $thumb = asset('images/profiles/no-image.png');

        if ($this->getFirstMediaUrl($collection, $type)) {
            $thumb = $this->getFirstMediaUrl($collection, $type);
        }

        //dd($collection, $type, $this->getFirstMediaUrl('main'));
        return $thumb;
    }

    /**
     * Devuelve la fecha de creación del usaurio
     */
    public function getCreadoAttribute()
    {
        return $this->created_at->format('M, d Y');
    }

    /**
     * Devuelve el nombre completo del usuaio
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }
    /**
     * Aplica los filtros del formulario de reporte
     */
    public function scopeParaReporte($query, Request $request)
    {
        if ($request->has('desde') && $request->has('hasta')) {
            $query->whereDate('created_at', '>=', $request->desde)
                ->whereDate('created_at', '<=', $request->hasta);
        }
        //si no ha seleccionado todos los roles
        if ($request->has('roles') && !empty($request->roles)) {
            $query->role($request->roles);
        }
        return $query;
    }


    public function inscritos(){
        return $this->hasMany(Inscrito::class, 'candidato_id');
    }


    /**
     * Los usuarios de un rol
     * @param $rol string | array
     */
    public function scopeConRol($query, $rol)
    {
        $query->whereIn('id', function ($q) use ($rol) {
            // model_id = user_id
            $q->from('model_has_roles')
            ->whereIn('role_id',  function ($q) use ($rol) {
                $q->from('roles')
                ->select('id');
                if (is_array($rol)) {
                    $q->whereIn('name', $rol);
                } else {
                    $q->where('name', $rol);
                }
            })
                ->where('model_type', User::class)
                ->select('model_id');
        });

        return $query;
    }
}