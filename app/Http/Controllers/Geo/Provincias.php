<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Provincia;
use Illuminate\Http\Request;

class Provincias extends Controller
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
        $provincias = Provincia::query();
        
        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if($estado!='') {
            $provincias = $provincias->where('estado',$estado);
        }

        //Filtros basicos, orden y paginacion
        $provincias = $provincias->where(function($q) use($query){
            $q->where('nombre','like',"%$query%")
            ->orWhere('gid2','like',"%$query%");
        })
        ->orderBy($sortBy,$sortDesc?'desc':'asc')
        ->paginate($perPage);

        return response()->json([
            'users' => $provincias->items(),
            'total'=>$provincias->total()
        ]);
    }

    
    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las provinicias
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions(){
        $provincias = Provincia::select('id','nombre','gid0','gid1')->get();

        return response()->json($provincias);
    }
}
