<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Resultados extends Controller
{
    public function totalesPorCandidato(Request $request){
        $totales = Candidato::select('candidatos.id',DB::raw('sum(votos)'))
                            ->join('candidato_acta','candidatos.id','=','candidato_acta.candidato_id')
                            ->groupBy('candidatos.id')
                            ->get();
        
        return response()->json([
            'status'    =>  true,
            'items'     =>  $totales
        ]);                 
    }
}
