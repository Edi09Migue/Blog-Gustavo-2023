<?php

namespace App\Models\ControlElectoral;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Optix\Media\HasMedia;
use OwenIt\Auditing\Contracts\Auditable;

class Acta extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory, SoftDeletes, HasMedia;

    protected $table = "actas";

    protected $fillable  = [
        'codigo',
        'junta_id',
        'votos_blancos',
        'votos_nulos',
        'votos_validos',
        'estado',
        'ingresada_por',
        'visualizado', #Para false si no fue consultada, true su fue consultada y están ingresando datos
    ];

    protected $appends = [
        'imagenURL',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'visualizado' => 'boolean'
    ];

   
    public function junta()
    {
        return $this->belongsTo(Junta::class);
    }

    public function ingresada()
    {
        return $this->belongsTo(User::class, 'ingresada_por');
    }

    public function candidatosActa(){
        return $this->belongsToMany(Candidato::class,'candidato_acta','acta_id','candidato_id')
        ->withPivot(['votos', 'digitalizado_por'])
        ->withTimestamps();  
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


    public function getIsAdminAttribute(){
        $is_admin = $this->roles()
                        ->whereIn('role_id',[1,2])
                        ->count();
        return $is_admin > 0;
    }



}