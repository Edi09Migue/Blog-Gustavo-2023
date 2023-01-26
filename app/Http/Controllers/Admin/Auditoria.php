<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;

class Auditoria extends Controller
{
        /**
     * Devuelve el listado de permisos paginados
     */
    public function index(Request $request)
    {
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : "true";


        $registros = Audit::with('user');
            
        if($request->has('fecha') && $request->fecha){
            $registros = $registros->whereDate('created_at', $request->fecha);
        }
            
        if($request->has('usuario')){
            $registros = $registros->where('user_id', $request->usuario);
        }
            
        if($request->has('entidad')){
            $registros = $registros->where('auditable_type', $request->entidad);
        }
            
        if($request->has('accion')){
            $registros = $registros->where('event', $request->accion);
        }

        //Filtros basicos, orden y paginacion
        $registros = $registros->where(function ($q) use ($query) {
            $q->where('auditable_type', 'like', "%$query%")
            ->orWhere('old_values', 'like', "%$query%")
            ->orWhere('ip_address', 'like', "%$query%")
            ->orWhere('new_values', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);


        return response()->json([
            'items' => $registros->items(),
            'total' => $registros->total()
        ]);
    }

    /**
     * Listado de entidades y sus totales
     */
    public function entidadesOptions(){
        $entidades = DB::table('audits')
                        ->select(DB::raw('count(auditable_type) as total'), 'auditable_type')
                        ->groupBy('auditable_type')
                        ->get();

        $entidades->each(function($e){
            $aux = explode("\\",$e->auditable_type);
            $aux = array_filter($aux,function($a){
                if(!in_array($a,['App','Models'])){
                    return true;
                }else{
                    return false;
                }
            });
            $e->entidad = implode(" - ",$aux);
        });

        return response()->json([
            'status'    =>  true,
            'items'          =>  $entidades
        ]);
    }

    /**
     * Listado de acciones y sus totales
     */
    public function accionesOptions(){
        $acciones = DB::table('audits')
                        ->select(DB::raw('count(event) as total'), 'event')
                        ->groupBy('event')
                        ->get();

        return response()->json([
            'status'    =>  true,
            'items'          =>  $acciones
        ]);
    }

    /**
     * Listado de usuarios que realizaron alguna acción en la plataforma y sus totales
     */
    public function usuariosOptions(){
        $usuarios = DB::table('audits')
                        ->select(DB::raw('count(user_id) as total'), 'user_id')
                        ->groupBy('user_id')
                        ->get();

        $usuarios->each(function ($u) {
            $u->usuario = User::find($u->user_id);
        });

        return response()->json([
            'status'    =>  true,
            'items'          =>  $usuarios
        ]);
    }

    
    

}
