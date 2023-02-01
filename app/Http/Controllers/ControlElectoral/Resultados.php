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

        $totales = Candidato::votosTotalesPorCandidato();
                            
        if($request->has('parroquia')){
            $totales = $totales->whereIn('parroquias.id',$request->parroquia);
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
        
        foreach($totales as $total){
            $total->nombre_corto = $total->nombreCorto;

            $total->total_validos = $total->candidatosActa()
                                        ->whereIn('acta_id',function($sq){
                                            $sq->select('id')
                                                ->from('actas')
                                                ->where('inconsistente',false);
                                        })->sum('votos');
            $total->total_inconsistentes = $total->candidatosActa()
                                        ->whereIn('acta_id', function ($sq) {
                                            $sq->select('id')
                                                ->from('actas')
                                                ->where('inconsistente', true);
                                        })->sum('votos');
        }
        
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
                                'parroquias.tipo as tipo',
                                DB::raw('sum(votos) as total_votos')
                            )
                            ->join('candidato_acta','candidatos.id','=','candidato_acta.candidato_id')
                            ->join('actas','actas.id','=','candidato_acta.acta_id')
                            ->join('juntas', 'juntas.id','=','actas.junta_id')
                            ->join('recintos', 'recintos.id','=','juntas.recinto_id')
                            ->join('parroquias', 'parroquias.id','=','recintos.parroquia_id');
        
        if($request->has('parroquia')){
            $totales = $totales->whereIn('parroquias.id',$request->parroquia);
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

        foreach($totales as $total){
            $total->nombre_corto = $total->nombreCorto;
        }

        $parroquias = $totales->groupBy('parroquia');
        $candidatos = $totales->groupBy('nombre_corto');
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
                            DB::raw('sum(total_votantes)-sum(votos_blancos)-sum(votos_nulos) as validos'),
                            )
                        ->join('juntas', 'juntas.id', '=', 'actas.junta_id')
                        ->join('recintos', 'recintos.id', '=', 'juntas.recinto_id')
                        ->join('parroquias', 'parroquias.id', '=', 'recintos.parroquia_id');

        if ($request->has('parroquia')) {
            $totales = $totales->whereIn('parroquias.id', $request->parroquia);
        }

        if ($request->has('recinto')) {
            $totales = $totales->where('recintos.id', $request->recinto);
        }

        if ($request->has('junta')) {
            $totales = $totales->where('juntas.id', $request->junta);
        }

        $totales = $totales->first();
                
        return response()->json([
            'status'    =>  true,
            'items'     =>  $totales
        ]);            
    }

    public function totalesEscrutados(Request $request){

        $total_electores = Recinto::query();

        $totales = Acta::sumTotalVotantes()
                        ->where('inconsistente',false);
        
        $totalesInconsistentes = Acta::sumTotalVotantes()
                                ->where('inconsistente',true);

        if ($request->has('parroquia')) {
            $total_electores = $total_electores->whereIn('parroquia_id', $request->parroquia);
            $totales = $totales->whereIn('parroquias.id', $request->parroquia);
            $totalesInconsistentes = $totalesInconsistentes->whereIn('parroquias.id', $request->parroquia);
        }

        if ($request->has('recinto')) {
            $total_electores = $total_electores->where('id', $request->recinto);
            $totales = $totales->where('recintos.id', $request->recinto);
            $totalesInconsistentes = $totalesInconsistentes->where('recintos.id', $request->recinto);
        }

        if ($request->has('junta')) {
            $totales = $totales->where('juntas.id', $request->junta);
            $totalesInconsistentes = $totalesInconsistentes->where('juntas.id', $request->junta);
        }

        $total_electores = $total_electores->sum('cantidad_electores');

        $totales = $totales->first();
        $totalesInconsistentes = $totalesInconsistentes->first();

        $resultado = [
            'total'             =>  $total_electores,
            'escrutados'        =>  $totales->total_votos,
            'inconsistentes'    =>  $totalesInconsistentes->total_votos,
            'por_escrutar'      =>  $total_electores - $totales->total_votos - $totalesInconsistentes->total_votos
        ];

        return response()->json([
            'status'    =>  true,
            'items'     =>  $resultado
        ]);            
    }

    /**
     * Devuelve el total de votos registrados en las actas agrupados por candidato
     * 
     * @param $parroquia int
     * @param $recinto int
     * @param $junta int
     */
    public function totalesPorCandidatoFake(Request $request)
    {

        $totales = Candidato::all();

        $total_electores = Recinto::sum('cantidad_electores');

        $pesos = [
            1   =>  3.4,  //sebastian davalos sanches
            2   =>  5.8,  //xavier vilcacundo
            3   =>  7.3,  //felipe bonilla
            4   =>  6.5,  //carlos ortega
            5   =>  0.3,  //myrian auz
            6   =>  17.2, //diana caiza,
            7   =>  15.1, //salome Marin
            8   =>  16.5, //amoros
            9   =>  17.8  //altamirano
            //10  =>  11.1 //Blancos
        ];

        
        foreach ($totales as $total) {
            $total->nombre_corto = $total->nombreCorto;

            $votos = $total_electores * ($pesos[$total->id]/100);
            $total->total_votos = (int)$votos;
            $total->total_validos = $votos;
            $total->total_inconsistentes = $votos;
        }

        return response()->json([
            'status'    =>  true,
            'items'     =>  $totales
        ]);
    }
}
