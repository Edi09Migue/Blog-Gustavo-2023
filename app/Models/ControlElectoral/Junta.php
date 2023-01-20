<?php

namespace App\Models\ControlElectoral;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Junta extends Model
{
    
    use HasFactory, SoftDeletes;

    protected $table = "juntas";

    protected $fillable  = [
        'codigo',
        'recinto_id',
        'tipo',
    ];

    protected $appends = [
        'para_select',
    ];    

    //Tipos disponibles para el enum 'tipo'
    public const TIPO_MASCULINO = "masculino";
    public const TIPO_FEMENINO = "femenino";

    public function recinto()
    {
        return $this->belongsTo(Recinto::class);
    }

    public function actas()
    {
        return $this->hasMany(Acta::class);
    }

    /**
     * Devuelve el el código y tipo de la junta
     */
    public function getParaSelectAttribute()
    {
        $para_select = strtoupper($this->codigo.' '.$this->tipo);
        return $para_select;
    }
}