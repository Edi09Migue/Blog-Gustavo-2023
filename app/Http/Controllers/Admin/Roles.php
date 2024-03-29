<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class Roles extends Controller
{
    var $datos;

    /**
     * Devuelve el Listado de los Roles del Sistema paginados, ordenados y filtrados
     */
    public function index(Request $request)
    {
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : "true";


        $roles = Role::where('name', 'like', "%$query%")
            ->orderBy($sortBy, $sortDesc == "true" ? 'desc' : 'asc')
            ->paginate($perPage);

        $roles->each(function ($r) {
            $r->permisos = $r->permissions->count();
            unset($r->permissions);
        });

        return response()->json([
            'items' => $roles->items(),
            'total' => $roles->total()
        ]);
    }

    /**
     * Devuelve los datos y los permisos de un rol
     * @param int $id //Clave primaria del rol
     */
    public function show($id)
    {
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
            'guard_name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        DB::beginTransaction();
        try {
            $role = Role::create($request->all());

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }
            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $role,
                'msg' => "{$role->name} creado correctamente!"
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|max:255',
            'guard_name' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        DB::beginTransaction();
        try {
            //Updating Role
            $role = Role::findOrFail($id);

            $role->update($request->all());

            if ($request->has('permissionsIDs')) {
                $role->syncPermissions($request->permissionsIDs);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $role,
                'msg' => "{$role->name} actualizado correctamente!"
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $e->getMessage(),
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
            'status' => TRUE,
            'id' => $id,
            'msg' => "{$rol->name} eliminado correctamente!"
        ]);
    }

    /**
     * Devuelve el id, nombre y grupo de todos los permisos 
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $permisos = Role::select('id', 'name')->get();

        return response()->json($permisos);
    }

    /**
     * Devuelve TRUE si el campo esta disponible
     */
    public function isUniqueField($field, Request $request)
    {
        $existe = Role::where($field, $request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe == 0),
            'msg' =>  $request->value . ($existe != 0 ? ' ya esta siendo utilizado por otro rol' : ' esta disponible')
        ]);
    }
}