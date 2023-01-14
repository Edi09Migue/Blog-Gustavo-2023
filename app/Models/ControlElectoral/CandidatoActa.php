<?php

namespace App\Models\ControlElectoral;

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

}