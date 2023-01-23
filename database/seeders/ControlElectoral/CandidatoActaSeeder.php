<?php

namespace Database\Seeders\ControlElectoral;

use App\Models\ControlElectoral\Acta;
use App\Models\ControlElectoral\Candidato;
use App\Models\ControlElectoral\CandidatoActa;
use App\Models\ControlElectoral\Recinto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidatoActaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('candidato_acta')->delete();
        DB::statement('ALTER TABLE candidato_acta AUTO_INCREMENT = 1');

        DB::table('actas')->delete();
        DB::statement('ALTER TABLE actas AUTO_INCREMENT = 1');

        $recintos = Recinto::all();

        $total_candidatos = Candidato::select('id')->count();
        $candidatos = Candidato::select('id','nombre')->inRandomOrder()->get();

        foreach($recintos as $recinto){
            // echo "Recinto: {$recinto->codigo} => votantes: {$recinto->cantidad_electores}\n";

            $total_electores_recinto = $recinto->cantidad_electores;
            
            $electores_x_junta = $total_electores_recinto / $recinto->total_juntas;

            $totalActas = 0;

            foreach($recinto->juntas as $junta){
                // echo "\tJunta: {$junta->codigo} => votantes: {$recinto->electores_x_junta} \n";


                //$totalActas += (int) $electores_x_junta;

        
                $codigo =  strtoupper($recinto->codigo.'-'.$junta->codigo.substr($junta->tipo,0,1));


                //la mitad de ley votan
                $total_votantes = $electores_x_junta/2;
                //le aumentamos un randomico entre la mitad restante
                $total_votantes = $total_votantes + rand(1,$total_votantes);
                //random entre los sobrantes
                $votos_nulos = rand(1, $electores_x_junta - $total_votantes);
                $votos_blancos = rand(1, $electores_x_junta - $total_votantes - $votos_nulos);


                $acta = Acta::create([
                    "codigo"            => $codigo,
                    "junta_id"          => $junta->id,
                    "total_votantes"     => $total_votantes,
                    "votos_blancos"     => $votos_blancos,
                    "votos_nulos"       => $votos_nulos,
                    "estado"            => true,
                    "ingresada_por"     => 3,
                    "visualizado"       => true,
                    "inconsistente"       => true,
                ]);

                $votados = 0;
                
                foreach($candidatos as $candidato){
                    $votos = rand(0, $total_votantes - $votados);
                    $votados += $votos;
                    // echo "\t\t {$candidato->nombre}: {$votos}\n";
                    $ca = CandidatoActa::create([
                        'candidato_id'      =>  $candidato->id,
                        'acta_id'           =>  $acta->id,
                        'votos'             =>  $votos,
                        'procesada_por'  =>  2
                    ]);
                }

            }
        }
    }



}

