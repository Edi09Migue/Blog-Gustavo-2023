<?php

namespace App\Models\ControlElectoral;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Optix\Media\HasMedia;

class Candidato extends Model
{
    use HasFactory, SoftDeletes, HasMedia;

    protected $table = "candidatos";

    protected $fillable  = [
        'nombre',
        'nombre_partido',
        'numero_lista',
        'total_votos',
    ];

    public function candidatosActa(){
        return $this->belongsToMany(Acta::class,'candidato_acta','candidato_id','acta_id')
        ->withPivot(['votos','digitalizado_por'])
        ->withTimestamps();  
    }

    public function scopeVotosTotalesPorCandidato($query){
        return $query->select(
                        'candidatos.id',
                        'candidatos.nombre',
                        'candidatos.nombre_partido',
                        'candidatos.numero_lista',
                        DB::raw('sum(votos) as total_votos')
                    )
                    ->join('candidato_acta','candidatos.id','=','candidato_acta.candidato_id')
                    ->join('actas','actas.id','=','candidato_acta.acta_id')
                    ->join('juntas', 'juntas.id','=','actas.junta_id')
                    ->join('recintos', 'recintos.id','=','juntas.recinto_id')
                    ->join('parroquias', 'parroquias.id','=','recintos.parroquia_id');
    }
}