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
}
