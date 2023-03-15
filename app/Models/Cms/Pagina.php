<?php

namespace App\Models\Cms;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Optix\Media\HasMedia;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Pagina extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory, SoftDeletes, HasMedia, HasSlug;

    protected $table = "paginas";

    protected $dates = ['fecha'];
    protected $casts = ['fecha'=> 'date'];

    protected $fillable  = [
        'titulo',
        'slug',
        'contenido',
        'fecha',
        'user_id',
        'estado',
    ];

    // para editar la imagen nombre igual método
    protected $appends = [
        'imagenURL'
    ];

    /**
     * Devuelve el tipo de modelo
     */
    public function getTipoModeloAttribute()
    {
        return "pagina";
    }

    /**
     * Devuelve el usuario de la página
     */
    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    /**
     * Relacion para las categorias de la página
     */
    public function categorias(){
        return $this->belongsToMany(CategoriaBlog::class,'categoria_paginas','pagina_id','categoria_id')->withTimestamps(); 
    }



     /**
     * Devuelve la URL completa de la imagen de la página
     */
    public function getImagenURLAttribute()
    {
        return $this->getFirstMediaUrl('main', 'articulo')
            ? $this->getFirstMediaUrl('main', 'articulo')
            : asset('images/cms/articulos/no-image.png');
    }

     /**
     * Registro de conversiones a distintos tamaños
     *  para imagenes asignadas a este modelo
     */
    public function registerMediaGroups()
    {
        $this->addMediaGroup('main')
            ->performConversions('articulo');
    }

      /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('titulo')
            ->saveSlugsTo('slug');
    }

    public function getFechaFormatedAttribute()
    {
        return $this->fecha->translatedFormat('d F Y');
    }

    

}
