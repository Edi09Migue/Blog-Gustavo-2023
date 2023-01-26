<?php

namespace App\Models\ControlElectoral;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Optix\Media\HasMedia;
use Optix\Media\Models\Media;
use OwenIt\Auditing\Contracts\Auditable;

class Acta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory, SoftDeletes, HasMedia;

    protected $table = "actas";

    protected $fillable  = [
        'codigo',
        'junta_id',
        'total_votantes',
        'votos_blancos',
        'votos_nulos',
        'estado', #False cuando el escaneado del acta es subida por un usuario
        'ingresada_por',
        'visualizado', #False para saber si no fue consultada, true cuando fue consultada y están ingresando los votos de los candidatos
        'inconsistente',
        'visualizado_por', #
    ];

    protected $appends = [
        'imagenURL',
        'imagenOriginalURL',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'visualizado' => 'boolean',
        'inconsistente' => 'boolean',
    ];

    /**
     * Devuelve la junta a la que pertenece la junta
     */
    public function junta()
    {
        return $this->belongsTo(Junta::class);
    }

    /**
     * Devuelve el usuario que ingreso el registro del acta
     */
    public function ingresada()
    {
        return $this->belongsTo(User::class, 'ingresada_por');
    }

    /**
     * Devuelve los votos de los canditados del acta
     * Esto luego de subir la imagen del acta
     */
    public function candidatosActa(){
        return $this->belongsToMany(Candidato::class,'candidato_acta','acta_id','candidato_id')
        ->withPivot(['votos', 'digitalizado_por'])
        ->withTimestamps();  
    }

    /**
     * Devuelve la URL completa de la imagen orginal del acta
     */
    public function getImagenOriginalURLAttribute(Type $var = null)
    {
        $acta = $this;
        $url = asset("images/control_electoral/no-imagen-acta.jpg");

        $media = Media::whereIn('id',  function ($query) use ($acta) {
            $query->select('media_id')->from('mediables')
            ->where('mediable_id',$acta->id)
            ->where('mediable_type',Acta::class);
        })->first();
        
        if ($media) 
            $url = asset("images/control_electoral/actas/{$media->file_name}");

        return $url;
    }

    /**
     * Devuelve la URL completa de la imagen
     */
    public function getImagenURLAttribute()
    {
        return $this->getFirstMediaUrl('main', 'acta')
            ? $this->getFirstMediaUrl('main', 'acta')
            : asset('images/control_electoral/actas/no-image.png');
    }

    /**
     * Registro de conversiones a distintos tamaños
    *  para iconos asignadas a este modelo
    */
    public function registerMediaGroups()
    {
        $this->addMediaGroup('main')
        ->performConversions('acta');
    }

}