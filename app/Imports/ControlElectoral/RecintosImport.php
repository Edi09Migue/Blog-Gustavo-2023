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
        foreach($collection as $index => $dato){
          
            if($index!=0 && $index>=1 && $index<=171  ){
            // if( $index!=0 && $index==1 ){
                // dd($dato);
                // echo $index."=".$dato[2]."\n";
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
    
                    if($recinto->juntas_femeninas > 0){
                        for ($x = 1; $x <= $recinto->juntas_femeninas; $x++) {
                            Junta::create([
                                "codigo"=> str_pad($x, 3, "0", STR_PAD_LEFT),
                                "recinto_id"=>$recinto->id,
                                "tipo"=>'femenino',
                            ]);
                       
                        }
                    }
    
                    if($recinto->juntas_masculinas > 0){
                        for ($y = 1; $y <= $recinto->juntas_masculinas; $y++) {
                            Junta::create([
                                "codigo"=>str_pad($y, 3, "0", STR_PAD_LEFT),
                                "recinto_id"=>$recinto->id,
                                "tipo"=>'masculino',
                            ]);
                       
                        }
                    }

                }
              


            }
        }
    }
}
