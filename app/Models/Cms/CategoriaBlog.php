<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Optix\Media\HasMedia;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CategoriaBlog extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

     use HasFactory, SoftDeletes, HasMedia, HasSlug;

     protected $table = "categorias_blog";

     protected $casts = ['estado'=> 'boolean'];

     
    protected $fillable  = [
        'nombre',
        'descripcion',
        'slug',
        'estado',
    ];

     protected $appends = [
        'imagenURL'
    ];

    /**
     * Devuelve la URL completa del icono de la categoría
     */
    public function getImagenURLAttribute()
    {
        return $this->getFirstMediaUrl('main', 'preview')
            ? $this->getFirstMediaUrl('main', 'preview')
            : asset('images/cms/categorias/no-image.png');
    }

     /**
     * Registro de conversiones a distintos tamaños
     *  para iconos asignadas a este modelo
     */
    public function registerMediaGroups()
    {
        $this->addMediaGroup('main')
            ->performConversions('thumb', 'preview', 'square');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
            ->saveSlugsTo('slug');
    }
}
