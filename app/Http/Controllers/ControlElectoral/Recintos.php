<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Recinto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Recintos extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Filtros para query
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? ($request->sortBy == "" ? "id" : $request->sortBy) : "id";
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc == "true" ? true : false) : false;

        //Obtengo una instancia de Pagina para el query
        $recintos = Recinto::query();

        //Si es admin o superadmin muestro las borradas
        if(Auth::user()->isAdmin){
            $recintos = $recintos->withTrashed();
        }

        //Filtros basicos, orden y paginacion
        $recintos = $recintos->where(function ($q) use ($query) {
            $q->where('codigo', 'like', "%$query%")
                ->orWhere('junta_id', 'like', "%$query%")
                ->orWhere('votos_blancos', 'like', "%$query%")
                ->orWhere('votos_nulos', 'like', "%$query%")
                ->orWhere('votos_validos', 'like', "%$query%")
                ->orWhere('procesado_por', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);
        

        return response()->json([
            'status' => true,
            'items' => $recintos->items(),
            'total' => $recintos->total()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
      
        DB::beginTransaction();
        try {

            $recinto = new Recinto($request->all());
            $recinto->save();

            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Recinto: {$recinto->nombre}",
                'data'      => $recinto

            ]);

        }catch (Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                    'msg' => 'Error al crear recinto'
                ]);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gaceta\Recinto  $recinto
     * @return \Illuminate\Http\Response
     */
    public function show(Recinto $recinto)
    {

        return response()->json([
            'status'    => TRUE,
            'data'      => $recinto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Recinto $recinto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recinto $recinto)
    {

        DB::beginTransaction();
        
        try {
            $recinto->fill($request->all());
            $recinto->save();



            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Recinto: {$recinto->nombre}",
                'data'      => $recinto
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'msg' => 'Error al crear recinto'
            ]);
        } 
    
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gaceta\Recinto $recinto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recinto $recinto)
    {
        $recinto->delete();
        return response()->json([
            'status'    => TRUE,
            'data'      => $recinto,
            'msg'       => "Recinto: {$recinto->nombre}"
        ]);
    }

    /**
     * Restaura el elemento borrado
    */
    public function restore($recinto){

        $recinto = Recinto::withTrashed()->find($recinto);
        
        $recinto->restore();

        return response()->json([
            'status' => true,
            'data' => $recinto,
            'msg'       => "Recinto: {$recinto->nombre}"

        ]);
    }


    /**
     * Devuelve todos los recintos
    */
    public function dropdownOptions()
    {
        $recinto = Recinto::get();

        return response()->json([
            'status'    =>  true,
            'items'     =>  $recinto
        ]);
    }










}
