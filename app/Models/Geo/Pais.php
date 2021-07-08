<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Pais extends Model
{
    use HasSlug;

    protected $table = "paises";

    protected $fillable = [
        'gid0',
        'nombre',
        'slug',
        'codigo',
        'orden',
        'estado',
        'minx',
        'miny',
        'maxx',
        'maxy',
        'lat',
        'lng',
        'zoom',
        'pitch',
        'bearing',
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
     * Provincias que conforman este pais
     */
    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'gid0', 'gid0');
    }
}