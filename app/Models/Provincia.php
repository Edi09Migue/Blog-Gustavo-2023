<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Provincia extends Model
{
    use HasSlug;
    
    protected $table = "provincias";

    protected $fillable = [
        'gid0',//pais
        'gid1',//provincia
        'nombre',
        'slug',
        'tipo',
        'engtype',
        'descripcion',
        'bandera_url',
        'escudo_url',
        'zipcode',
        'minx',
        'miny',
        'maxx',
        'maxy',
        'lat',
        'lng',
        'zoom',
        'estado',
        'pitch',
        'bearing'
    ];

    public $timestamps = false;

     
    protected $appends = [
        'iconoURL',
    ];
    
     /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
            ->saveSlugsTo('slug');
    }

    /**
     * Pais al que pertenece la provincia
     */
    public function pais(){
        return $this->belongsTo(Pais::class,'gid0','gid0');
    }

    /**
     * Parroquias que conforman este cantón
     */
    public function cantones(){
        return $this->hasMany(Canton::class,'gid1','gid1');
    }

        
    /**
     * Devuelve la URL completa de la imagen de portada de la parroquia
     */
    public function getIconoURLAttribute(){
        return asset('images/ECU.23.8_1.svg');
    }
}
