<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Optix\Media\HasMedia;
use OwenIt\Auditing\Contracts\Auditable;

class Slider extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory, SoftDeletes, HasMedia;

    protected $table = "sliders";

    protected $casts = ['externo'=> 'boolean', 'visible'=> 'boolean'];

    protected $fillable  = [
        'title',
        'subtitle',
        'descripcion',
        'url',
        'texto_boton',
        'externo',
        'orden',
        'visible',
        'title_2',
    ];

    protected $appends = [
        'imagenURL'
    ];

    /**
     * Devuelve la URL completa de la imagen del slider
     */
    public function getImagenURLAttribute()
    {
        return $this->getFirstMediaUrl('main')
            ? $this->getFirstMediaUrl('main')
            : asset('images/cms/sliders/no-image.png');
    }

     /**
     * Registro de conversiones a distintos tamaños
     *  para imagenes asignadas a este modelo
     */
    public function registerMediaGroups()
    {
        $this->addMediaGroup('main')
            ->performConversions('slider');
    }









}
