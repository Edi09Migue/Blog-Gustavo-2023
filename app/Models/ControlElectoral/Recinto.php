<?php

namespace App\Models\ControlElectoral;

use App\Models\Geo\Canton;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recinto extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = "recintos";

    protected $fillable  = [
        'canton_id',
        // 'parroquia_id',
        'parroquia',
        'zonificacion',
        'tipo',
        'zona',
        'codigo',
        'nombre',
        'direccion',
        'telefono',
        'juntas_femeninas',
        'juntas_masculinas',
        'total_juntas',
        'cantidad_electores',
        'cda',
        'cda_destino',
    ];

    protected $casts = [
        'cda' => 'boolean'
    ];



    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

    public function juntas()
    {
        return $this->hasMany(Junta::class);
    }

    // public function parrqouia()
    // {
    //     return $this->belongsTo(Parroquia::class);
    // }



}