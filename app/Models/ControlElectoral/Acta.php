<?php

namespace App\Models\ControlElectoral;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        'totalVotosCandidatos',
        'totalBNC',
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

    public function scopeSumTotalVotantes($query){
        return $query->select(
                //DB::raw('sum(votos_blancos) + sum(votos_nulos) + sum(votos_validos) as total_votos')
                DB::raw('sum(total_votantes) as total_votos')
            )
            ->join('juntas', 'juntas.id', '=', 'actas.junta_id')
            ->join('recintos', 'recintos.id', '=', 'juntas.recinto_id')
            ->join('parroquias', 'parroquias.id', '=', 'recintos.parroquia_id');
    }

    /**
     * Devuelve la suma de los votos obtenidos por los candidatos en cada acta
     */
    public function getTotalVotosCandidatosAttribute()
    {
        $total_votos = 0; 

        $candidatosActa = CandidatoActa::where('acta_id',  $this->id)->get();

        foreach($candidatosActa as $candidato_acta){
            $total_votos += $candidato_acta->votos;
        }

        return $total_votos;
    }


     /**
     * Devuelve la suma de lso votos obtenidos por los candidatos en cada acta
     */
    public function getTotalBNCAttribute()
    {
        $total_bnc = 0; 
        $total_votos = 0; 

        $candidatosActa = CandidatoActa::where('acta_id',  $this->id)->get();

        foreach($candidatosActa as $candidato_acta){
            $total_votos += $candidato_acta->votos;
        }

        $total_bnc =   $total_votos + $this->votos_blancos + $this->votos_nulos;
        return $total_bnc;
    }


     /**
     * Devuelve los votos de cada candidato
     */
    public function getVotosCandidatosAttribute()
    {

        $candidatosActa = CandidatoActa::where('acta_id',  $this->id)->get();
        return $candidatosActa;
    }


    /**
     * Aplica los filtros del formulario de reporte
     */
    public function scopeParaReporte($query, Request $request)
    {
        
        //si ha seleccionado un tipo de acta
        if ($request->has('tipo') && !empty($request->tipo)) {
            if($request->tipo == 'procesadas'){
                $query->where('estado', true);
            } else if ($request->tipo == 'inconsistentes'){
                $query->where('estado', true)->where('inconsistente', true);
            } else if ($request->tipo == 'consistentes'){
                $query->where('estado', true)->where('inconsistente', false);
            }
        }

        //si ha seleccionado parroquias
          if ($request->has('parroquias') && !empty($request->parroquias)) {
            $query->whereIn('junta_id', function($q) use ($request){
                $q->select('id');
                $q->from('juntas');
                $q->whereIn('recinto_id', function($sq) use ($request){
                    $sq->select('id');
                    $sq->from('recintos');
                    $sq->whereIn('parroquia_id', $request->parroquias);
                });
            });
        }


         //si ha seleccionado recintos
         if ($request->has('recintos') && !empty($request->recintos)) {
            $query->whereIn('junta_id', function($q) use ($request){
                $q->select('id');
                $q->from('juntas');
                $q->whereIn('recinto_id', $request->recintos);
            });
        }

        //Falta controlar sin seleccionar todas los recintos dos parroquias

        return $query;
    }

    

}