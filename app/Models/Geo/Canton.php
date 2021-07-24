<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Optix\Media\HasMedia;

class Canton extends Model
{
    use HasSlug, HasMedia, HasFactory;

    protected $table = "cantones";

    protected $fillable = [
        'gid0', //pais
        'gid1', //provincia
        'gid2', //canton
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
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
            ->saveSlugsTo('slug');
    }

    /**
     * Provincia al que pertenece el canton
     */
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'gid1', 'gid1');
    }

    /**
     * Parroquias que conforman este cantón
     */
    public function parroquias()
    {
        return $this->hasMany(Parroquia::class, 'gid2', 'gid2');
    }


    /**
     * Devuelve la URL completa de la imagen de portada de la parroquia
     */
    public function getIconoURLAttribute()
    {
        return asset('images/maps/' . $this->gid1 . '/' . $this->gid2 . '.svg');
    }
}