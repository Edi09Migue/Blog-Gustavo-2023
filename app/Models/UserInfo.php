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
        'birthdate',
        'telefono',
        'website',
        'idioma',
        'genero',
        'contact_options',
        'pais',
        'social',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
