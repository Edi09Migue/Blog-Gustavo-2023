<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Canton;
use Illuminate\Http\Request;

class Cantones extends Controller
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
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc=="true" ? true : false) : false;
        
        //Obtengo una instancia de Usuarios para el query
        $cantones = Canton::query();
        
        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if($estado!='') {
            $cantones = $cantones->where('estado',$estado);
        }

        //Filtros basicos, orden y paginacion
        $cantones = $cantones->where(function($q) use($query){
            $q->where('nombre','like',"%$query%")
            ->orWhere('gid1','like',"%$query%")
            ->orWhere('gid2','like',"%$query%");
        })
        ->orderBy($sortBy,$sortDesc?'desc':'asc')
        ->paginate($perPage);

        return response()->json([
            'users' => $cantones->items(),
            'total'=>$cantones->total()
        ]);
    }

    
    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las cantones
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions(){
        $cantones = Canton::select('id','nombre','gid0','gid1','gid2')->get();

        return response()->json($cantones);
    }
}
