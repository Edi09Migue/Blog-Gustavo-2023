<?php

namespace App\Models\Geo;

use App\Models\ControlElectoral\Acta;
use App\Models\ControlElectoral\Recinto;
use Illuminate\Database\Eloquent\Model;
use Optix\Media\HasMedia;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Parroquia extends Model
{
    use HasMedia, HasSlug, HasFactory;

    protected $table = "parroquias";

    protected $fillable = [
        'gid0', //pais
        'gid1', //provincia
        'gid2', //canton
        'gid3', //parroquia
        'nombre',
        'nombre_corto',
        'slogan',
        'descripcion',
        'tipo',
        'slug',
        'engtype',
        'descripcion',
        'zipcode',
        'imagen',
        'icono',
        'estado',
        'orden',
        'bandera_url',
        'escudo_url',

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

    public $timestamps = false;


    protected $appends = [
        'URL',
        'imagenURL',
        'iconoURL',
        'codigo',
        'countActas'
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
     * Cantón al que pertenece la parroquía
     */
    public function canton()
    {
        return $this->belongsTo(Canton::class, 'gid2', 'gid2');
    }

    /**
     * Cantón al que pertenece la parroquía
     */
    public function provincia()
    {
        return $this->canton->provincia;
    }

    public function getCodigoAttribute()
    {
        $provincia_code = substr($this->gid2, 0, -2);
        return substr($this->gid3, strlen($provincia_code) + 1, -2);
    }

    /**
     * Devuelve la URL completa de la imagen de portada de la parroquia
     */
    public function getImagenURLAttribute()
    {
        return $this->imagen ? asset('images/parroquias/' . $this->imagen) : asset('images/parroquias/default.jpg');
    }

    /**
     * Devuelve la URL completa de la imagen de portada de la parroquia
     */
    public function getIconoURLAttribute()
    {
        return asset('images/maps/' . $this->gid1 . '/' . $this->gid2 . '.svg');
    }

    /**
     * Devuelve la URL completa de la imagen de portada del lugar
     */
    public function getURLAttribute()
    {
        return '';
    }

    public function recintos()
    {
        return $this->hasMany(Recinto::class);
    }


    /**
     * Devuelve la cantidad de actas procesadas
     */
    public function getCountActasAttribute()
    {
        $actas = Acta::whereIn('junta_id', function($q){
            $q->select('id');
            $q->from('juntas');
            $q->whereIn('recinto_id', function($sq){
            $sq->select('id');
            $sq->from('recintos');
            $sq->where('parroquia_id', $this->id);
            });
        });

        return $actas->count();
    }


}