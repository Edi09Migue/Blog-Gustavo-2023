<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\Pais;
use Illuminate\Http\Request;

class Paises extends Controller
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
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc == "true" ? true : false) : false;

        //Obtengo una instancia de Usuarios para el query
        $paises = Pais::query();

        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if ($estado != '') {
            $paises = $paises->where('estado', $estado);
        }

        //Filtros basicos, orden y paginacion
        $paises = $paises->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('gid0', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'users' => $paises->items(),
            'total' => $paises->total()
        ]);
    }


    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las paises
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $paises = Pais::select('id', 'nombre', 'gid0')->get();

        return response()->json($paises);
    }
}
