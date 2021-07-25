<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = "configuraciones";

    protected $fillable = [
        'key',
        'value',
        'configuracion',
        'tipo',
        'descripcion',
        'group_key'
    ];


    /**
     * Devuelve el valor de una configuracion por su key
     * @param $query 
     * @param $key string
     * @return string 
     */
    public function scopeValor($query, $key)
    {
        $setting = $query->where('key', $key)->first();
        return $setting ? $setting->value : "";
    }

    /**
     * Devuelve la URL completa de la iamgen 
     * si la configuracion es de tipo 'image'
     */
    public function getImageUrlAttribute()
    {
        $path = "";
        if ($this->tipo == "image") {
            $path = asset("images/uploads/" . $this->value);
        }
        return $path;
    }
}