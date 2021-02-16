<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Roles extends Controller
{
    var $datos;

     /**
     * Muestra el Listado de los Roles del Sistema
     */
    public function index(Request $request)
    {
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : true;

        $roles = Role::where('name','like',"%$query%")
                        ->orderBy($sortBy,$sortDesc?'desc':'asc')
                        ->paginate($request->perPage);

        $roles->each(function($r){
            $r->permisos = $r->permissions->count();
            unset($r->permissions);
        });

        return response()->json([
            'roles' => $roles->items(),
            'total' => $roles->count()
        ]);
    }

    public function show($id){
        $role = Role::findOrFail($id);

        $role->permissions;
       // dd($role->permissions, $role->permissions->pluck('id'));

        return response()->json([
            'status' => true,
            'data' => $role,
            'msg' => 'Rol'
        ]);
    }

    /**
     * Crea un Rol con sus respectivos permisos
     * @param  Request
     * @return [type]
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name,
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $role,
                'msg' => 'Rol creado correctamente!'
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $role,
                'msg' => 'Error al crear rol!'
            ]);
        }
    }

    /**
     * Editar rol y sus respectivos permisos
     * @param  [integer] 
     * @param  Request
     * @return [type]
     */
    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            //Updating Role
            $role = Role::findOrFail($id);

            $role->update(['name' => $request->name]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $role,
                'msg' => 'Rol actualizado correctamente!'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $role,
                'msg' => 'Error al actualizar rol!'
            ]);
        }
    }

    /**
     * @param  Toma el id de un Rol y lo elimina con sus respectivos permisos
     */
    public function destroy($id, Request $request)
    {
        $rol = Role::find($id);
        $rol->delete();

        return response()->json([
            'status'=>TRUE,
            'id' =>$id,
            'msg' => 'Rol eliminado correctamente!'
        ]);
    }
}
