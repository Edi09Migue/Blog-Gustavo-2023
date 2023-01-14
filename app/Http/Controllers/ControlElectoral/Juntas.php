<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Junta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Juntas extends Controller
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
        $juntas = Junta::with('junta.junta');

        //Si es admin o superadmin muestro las borradas
        if(Auth::user()->isAdmin){
            $juntas = $juntas->withTrashed();
        }

        //Filtros basicos, orden y paginacion
        $juntas = $juntas->where(function ($q) use ($query) {
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
            'items' => $juntas->items(),
            'total' => $juntas->total()
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

            $junta = new Junta($request->all());
            $junta->save();

            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Junta: {$junta->nombre}",
                'data'      => $junta

            ]);

        }catch (Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                    'msg' => 'Error al crear junta'
                ]);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gaceta\Junta  $junta
     * @return \Illuminate\Http\Response
     */
    public function show(Junta $junta)
    {

        return response()->json([
            'status'    => TRUE,
            'data'      => $junta
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Junta $junta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Junta $junta)
    {

        DB::beginTransaction();
        
        try {
            $junta->fill($request->all());
            $junta->save();



            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Junta: {$junta->nombre}",
                'data'      => $junta
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'msg' => 'Error al crear junta'
            ]);
        } 
    
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gaceta\Junta $junta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Junta $junta)
    {
        $junta->delete();
        return response()->json([
            'status'    => TRUE,
            'data'      => $junta,
            'msg'       => "Junta: {$junta->nombre}"
        ]);
    }

    /**
     * Restaura el elemento borrado
    */
    public function restore($junta){

        $junta = Junta::withTrashed()->find($junta);
        
        $junta->restore();

        return response()->json([
            'status' => true,
            'data' => $junta,
            'msg'       => "Junta: {$junta->nombre}"

        ]);
    }


    /**
     * Devuelve todos los juntas
    */
    public function dropdownOptions()
    {
        $junta = Junta::get();

        return response()->json([
            'status'    =>  true,
            'items'     =>  $junta
        ]);
    }










}
