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

        'pais',
        'provincia',
        'ciudad',
        'postalcode',
        'direccion_principal',
        'direccion_secundaria',

        'social',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
