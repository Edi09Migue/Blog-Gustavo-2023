<?php

namespace App\Imports\ControlElectoral;

use App\Models\ControlElectoral\Junta;
use App\Models\ControlElectoral\Recinto;
use App\Models\Geo\Parroquia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RecintosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        $parroquiaN = $collection[1][2];
        $zona = $collection[1][3];
        $topeF = 0;
        $recinto = null;
        $secuenciaJunta = 0; # Ejemplo 1, 2, 3, 4, 5, 
                            # Ejemplo la 6 una sola vez, 
        $pAnterior = null;

        foreach($collection as $index => $dato){
          
            if($index!=0 && $index>=1 && $index<=171  ){
            // if( $index!=0 && $index==1 ){
                // echo $index."=".$dato[2]."\n";
                if($dato[1]=='AMBATO'){
                    echo "{$index} \n";
                    // dd($topeF);
                    $parroquia = Parroquia::where('gid2','ECU.23.1_1')->where('nombre',$dato[2])->first();
                    
                    if($parroquia){

                        $recinto = Recinto::create([
                            "canton_id" => 133,
                            "parroquia_id" => $parroquia->id,
                            // "parroquia" => $dato[2],
                            "zonificacion" => $dato[3],
                            "tipo" => $dato[4],
                            "zona" => $dato[5],
                            "codigo" => $dato[6],
                            "nombre" => $dato[7],
                            "direccion" => $dato[8],
                            "telefono" => $dato[9],
                            "juntas_femeninas" => $dato[10],
                            "juntas_masculinas" => $dato[11],
                            "total_juntas" => $dato[12],
                            "cantidad_electores" => $dato[17],
                            "cda" => $dato[18] == 'SI' ? true : false,
                            "cda_destino" => $dato[19],
                        ]);

                        if($recinto!=null){
                            
                            $topeF = $dato[10];
                            $parroquiaN = trim(strtoupper($parroquia->nombre));
                            
                            $zona = trim(strtoupper($dato[3] == null ? $parroquiaN : $dato[3]));
                            // echo "tope = {$topeF} zona = {$zona} parroquia = {$parroquiaN}\n";

                            $pAnterior = $collection[$index-1][2];
                            
                            echo "pAnterior = {$pAnterior} pActual = {$parroquiaN} tope = {$topeF} zona = {$zona} \n";

                            if($collection[$index][2] != null && $collection[$index][3] != null){
                                if(  $parroquiaN != $zona){
                                    $secuenciaJunta = 0;
                                    echo "Aqui secuencias  {$secuenciaJunta} \n";
                                }
                            }else if($parroquiaN != null && $pAnterior){
                                $secuenciaJunta = 0;
                            }

                            for ($x = 1; $x <= $topeF; $x++) {

                                $secuenciaJunta = $secuenciaJunta + 1;

                                
                                $j = Junta::create([
                                    "codigo"=> str_pad($secuenciaJunta, 3, "0", STR_PAD_LEFT),
                                    "recinto_id"=>$recinto->id,
                                    "tipo"=>'femenino',
                                ]);
                                
                                echo "Guardado  {$x}, secuencia = {$secuenciaJunta}   codigo = {$j->codigo}  parroquia {$parroquiaN}, zona = {$zona},\n";
                            }

                            
                            
                        }

                    }
                }

                // if($index==70)
                //     dd('manuel');
            }
        }
    }
}
