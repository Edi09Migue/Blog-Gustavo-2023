<?php

namespace App\Imports\ControlElectoral;

use App\Models\ControlElectoral\Candidato;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CandidatosImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $index => $dato){
          
            if($index!=0 && $index>=1 && $index<=10  ){
            // if( $index!=0 && $index==1 ){
                // dd($dato);
                // echo $index."=".$dato[2]."\n";
                Candidato::create([
                    "nombre" => $dato[1],
                    "nombre_partido" => $dato[2],
                    "numero_lista" => $dato[3],
                    "total_votos" => $dato[4],
                   
                ]);


             

            }
        }
    }
}
