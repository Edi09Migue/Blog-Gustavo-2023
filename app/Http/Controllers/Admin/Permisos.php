<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class Permisos extends Controller
{
    var $datos;

    /**
     * Devuelve el listado de permisos paginado
     */
    public function index(Request $request)
    {
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : "true";


        $permisos = Permission::where('name', 'like', "%$query%")
            ->orderBy($sortBy, $sortDesc == "true" ? 'desc' : 'asc')
            ->paginate($perPage);


        return response()->json([
            'items' => $permisos->items(),
            'total' => $permisos->total()
        ]);
    }

    /**
     * Devuelve el id, nombre y grupo de todos los permisos 
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $permisos = Permission::select('id', 'name', 'group_key')->get();

        return response()->json($permisos);
    }

    /**
     * Crea un Rol con sus respectivos permisos
     * @param  Request
     * @return [type]
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions',
            'guard_name' => 'required',
            'group_key' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        $permiso = Permission::create([
            'name'          => $request->name,
            'guard_name'    => $request->guard_name,
            'group_key'     => $request->group_key
        ]);

        return response()->json([
            'status' => true,
            'data' => $permiso,
            'msg' => $permiso->name . ' creado!'
        ]);
    }

    /**
     * Editar rol y sus respectivos permisos
     * @param  [integer] 
     * @param  Request
     * @return [type]
     */
    public function update($id, Request $request)
    {
        try {
            //Updating Role
            $permiso = Permission::findOrFail($id);

            $permiso->update([
                'name'          => $request->name,
                'guard_name'    => $request->guard_name,
                'group_key'     => $request->group_key
            ]);
            return response()->json([
                'status' => TRUE,
                'data' => $permiso,
                'msg' => $permiso->name . ' actualizado!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                //'data' => $e,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param  Toma el id de un Rol y lo elimina con sus respectivos permisos
     */
    public function destroy($id, Request $request)
    {
        $permiso = Permission::find($id);
        $permiso->delete();

        return response()->json([
            'status' => TRUE,
            'id' => $id,
            'msg' => $permiso->name . ' eliminado!'
        ]);
    }



    /**
     * Devuelve TRUE si el campo esta disponible
     */
    public function isUniqueField($field, Request $request)
    {
        $existe = Permission::where($field, $request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe == 0),
            'msg' =>  $request->value . ($existe != 0 ? ' ya esta siendo utilizado por otro rol' : ' esta disponible')
        ]);
    }
}