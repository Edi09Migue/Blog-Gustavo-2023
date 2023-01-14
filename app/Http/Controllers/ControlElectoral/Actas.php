<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Acta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Optix\Media\Models\Media;

class Actas extends Controller
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
        $actas = Acta::with('junta.recinto');

        //Si es admin o superadmin muestro las borradas
        if(Auth::user()->isAdmin){
            $actas = $actas->withTrashed();
        }

        //Filtros basicos, orden y paginacion
        $actas = $actas->where(function ($q) use ($query) {
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
            'items' => $actas->items(),
            'total' => $actas->total()
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

            $acta = new Acta($request->all());
            $acta->save();

            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Acta: {$acta->nombre}",
                'data'      => $acta

            ]);

        }catch (Exception $e) {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'error' => $e->getMessage(),
                    'msg' => 'Error al crear acta$acta'
                ]);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gaceta\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function show(Acta $acta)
    {

        return response()->json([
            'status'    => TRUE,
            'data'      => $acta
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Acta $acta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acta $acta)
    {

        DB::beginTransaction();
        
        try {
            $acta->fill($request->all());
            $acta->save();



            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Acta: {$acta->nombre}",
                'data'      => $acta
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'msg' => 'Error al crear acta$acta'
            ]);
        } 
    
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gaceta\Acta $acta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acta $acta)
    {
        $acta->delete();
        return response()->json([
            'status'    => TRUE,
            'data'      => $acta,
            'msg'       => "Acta: {$acta->nombre}"
        ]);
    }

    /**
     * Restaura el elemento borrado
    */
    public function restore($acta){

        $acta = Acta::withTrashed()->find($acta);
        
        $acta->restore();

        return response()->json([
            'status' => true,
            'data' => $acta,
            'msg'       => "Acta: {$acta->nombre}"

        ]);
    }


    /**
     * Devuelve el id, nombre  de todos las categiorias
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $acta = Acta::orderBy('nombre', 'asc')->get();
        return response()->json([
            'status'    =>  true,
            'items'     =>  $acta
        ]);
    }


       
    /**
     * Devuelve TRUE si el campo esta disponible
     */
    public function isUniqueField($field, Request $request){
        $existe = Acta::where($field,$request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe==0),
            'msg' =>  $request->value. ($existe!=0 ? ' ya esta siendo utilizado por otra categoría' : ' esta disponible')
        ]);
    }








}
