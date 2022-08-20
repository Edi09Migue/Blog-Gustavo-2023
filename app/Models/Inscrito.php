<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{
    use HasFactory;

    protected $table = "inscritos";

    protected $fillable = [
        'nombre',
        'telefono',
        'ciudad',
        'parroquia',
        'candidato_id',
        'creado_por'
    ];

    public function candidato(){
        return $this->belongsTo(User::class,'candidato_id','id');
    }

    public function creador(){
        return $this->belongsTo(User::class,'creado_por','id');
    }
}
