<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Acta;
use App\Models\ControlElectoral\Candidato;
use App\Models\ControlElectoral\Recinto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Resultados extends Controller
{

    /**
     * Devuelve el total de votos registrados en las actas agrupados por candidato
     * 
     * @param $parroquia int
     * @param $recinto int
     * @param $junta int
     */
    public function totalesPorCandidato(Request $request){

        $totales = Candidato::select(
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
                            
        if($request->has('parroquia')){
            $totales = $totales->where('parroquias.id',$request->parroquia);
        }

        if($request->has('recinto')){
            $totales = $totales->where('recintos.id',$request->recinto);
        }

        if($request->has('junta')){
            $totales = $totales->where('juntas.id',$request->junta);
        }

        $totales = $totales->groupBy(
            'candidatos.id',
            'candidatos.nombre',
            'candidatos.nombre_partido',
            'candidatos.numero_lista'
        );

        $totales = $totales->get();
        
        return response()->json([
            'status'    =>  true,
            'items'     =>  $totales
        ]);                 
    }

    public function totalesPorCandidatoParroquia(Request $request){

        $totales = Candidato::select(
                                'candidatos.id',
                                'candidatos.nombre',
                                'candidatos.nombre_partido',
                                'candidatos.numero_lista',
                                'parroquias.id',
                                'parroquias.nombre as parroquia',
                                'parroquias.engtype as tipo',
                                DB::raw('sum(votos) as total_votos')
                            )
                            ->join('candidato_acta','candidatos.id','=','candidato_acta.candidato_id')
                            ->join('actas','actas.id','=','candidato_acta.acta_id')
                            ->join('juntas', 'juntas.id','=','actas.junta_id')
                            ->join('recintos', 'recintos.id','=','juntas.recinto_id')
                            ->join('parroquias', 'parroquias.id','=','recintos.parroquia_id');
        
        if($request->has('parroquia')){
            $totales = $totales->where('parroquias.id',$request->parroquia);
        }

        if($request->has('recinto')){
            $totales = $totales->where('recintos.id',$request->recinto);
        }

        if($request->has('junta')){
            $totales = $totales->where('juntas.id',$request->junta);
        }
        
        $totales = $totales->groupBy(
                                'candidatos.id',
                                'candidatos.nombre',
                                'candidatos.nombre_partido',
                                'candidatos.numero_lista',
                                'parroquias.id',
                                'parroquia',
                                'tipo',
                            );
        $totales = $totales->get();

        $parroquias = $totales->groupBy('parroquia');
        $candidatos = $totales->groupBy('nombre');
        $nombres_candidatos = array_keys($candidatos->toarray());
        $nombres_parroquias = array_keys($parroquias->toarray());
        

        return response()->json([
            'status'    =>  true,
            'items'     =>  $parroquias,
            'parroquias' =>  $nombres_parroquias,
            'candidatos' =>  $nombres_candidatos
        ]);                 
    }

    public function totalesPorTipoVoto(Request $request){
        $totales = Acta::select(
                            DB::raw('sum(votos_blancos) as blancos'),
                            DB::raw('sum(votos_nulos) as nulos'),
                            DB::raw('sum(votos_validos) as validos'),
                            )
                        ->first();
                
        return response()->json([
            'status'    =>  true,
            'items'     =>  $totales
        ]);            
    }

    public function totalesEscrutados(Request $request){

        $total_electores = Recinto::sum('cantidad_electores');
        
        $totales = Acta::select(
                            DB::raw('sum(votos_blancos) + sum(votos_nulos) + sum(votos_validos) as total_votos')
                            )
                        ->first();
        $resultado = [
            'total'         =>  $total_electores,
            'escrutados'    =>  $totales->total_votos,
            'por_escrutar'  =>  $total_electores -$totales->total_votos
        ];

        return response()->json([
            'status'    =>  true,
            'items'     =>  $resultado
        ]);            
    }
}
