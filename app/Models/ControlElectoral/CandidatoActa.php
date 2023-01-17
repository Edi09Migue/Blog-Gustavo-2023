<?php

namespace App\Models\ControlElectoral;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidatoActa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "candidato_acta";

    protected $fillable  = [
        'candidato_id',
        'acta_id',
        'votos',
        'digitalizado_por',
    ];

    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function acta()
    {
        return $this->belongsTo(Acta::class);
    }

    public function digitalizado()
    {
        return $this->belongsTo(User::class,'digitalizado_por');
    }



}