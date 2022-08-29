<?php

namespace App\Models;

use App\Models\Geo\Parroquia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Inscrito extends Model
{
    use HasFactory;

    protected $table = "inscritos";

    protected $fillable = [
        'nombre',
        'telefono',
        'candidato_id',
        'parroquia_id',
        'creado_por'
    ];

    public function parroquia(){
        return $this->belongsTo(Parroquia::class,'parroquia_id','id');
    }

    public function candidato(){
        return $this->belongsTo(User::class,'candidato_id','id');
    }

    public function creador(){
        return $this->belongsTo(User::class,'creado_por','id');
    }

    /**
     * Aplica los filtros del formulario de reporte
     */
    public function scopeParaReporte($query, Request $request)
    {
        if ($request->has('desde') && $request->has('hasta')) {
            $query->whereDate('created_at', '>=', $request->desde)
                ->whereDate('created_at', '<=', $request->hasta);
        }
        //si no ha seleccionado todos los candidatos
        if ($request->has('candidatos') && !empty($request->candidatos)) {
            $query->whereIn('candidato_id',$request->candidatos);
        }

        //si no ha seleccionado todos los parroquias
        if ($request->has('parroquias') && !empty($request->parroquias)) {
            $query->whereIn('parroquia_id',$request->parroquias);
        }
        
        return $query;
    }
}
