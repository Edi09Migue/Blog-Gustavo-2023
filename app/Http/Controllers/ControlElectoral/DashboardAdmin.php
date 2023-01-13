<?php

namespace App\Http\Controllers\ControlElectoral;


use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Candidato;
use App\Models\ControlElectoral\Junta;
use App\Models\ControlElectoral\Recinto;
use Illuminate\Http\Request;

class DashboardAdmin extends Controller 
{
    public function counters(Request $request)
    {
     
        $data = [
            'total_recintos'    =>  Recinto::count(),
            'total_juntas'    =>  Junta::count(),
            'total_candidatos'    =>  Candidato::count(),
  
        ];

    
        return response()->json($data);

        
    }

    

}
