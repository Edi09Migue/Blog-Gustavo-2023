<?php

namespace App\Models\ControlElectoral;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function votosCandidatoActa(){
        return $this->belongsToMany(Acta::class,'votos_candidato_acta','candidato_id','acta_id')
        ->withPivot(['votos','digitalizado_por'])
        ->withTimestamps();  
    }

}