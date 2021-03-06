<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = "user_info";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'empresa',
        'portada',
        
        'birthdate',
        'telefono',
        'website',
        'idioma',
        'genero',
        'contact_options',

        'bio',
        
        'pais',
        'provincia',
        'ciudad',
        'postalcode',
        'direccion_principal',
        'direccion_secundaria',

        'social',
    ];

    protected $appends = [
        'portadaURL'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'social' => 'json',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Devuelve la URL completa de la imagen de portada del usuario
     */
    public function getportadaURLAttribute(){
        return asset('images/profiles/'. ($this->portada ? $this->portada :'timeline.jpg'));
    }
}
