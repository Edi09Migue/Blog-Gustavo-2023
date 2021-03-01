<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class Configuraciones extends Controller
{
    var $datos;

    /**
     * Devuelve el listado de permisos paginado
     */
    public function index(Request $request){
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 50;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : "true";

        
        $permisos = Configuracion::where('key','like',"%$query%")
                        ->orderBy($sortBy,$sortDesc=="true"?'desc':'asc')
                        ->paginate($perPage);

    	
    	return response()->json([
            'items' => $permisos->items(),
            'total' => $permisos->count()
        ]);
    }
    
    /**
     * Crea un Rol con sus respectivos permisos
     * @param  Request
     * @return [type]
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'key' => 'required|unique:configuraciones',
            'value' => 'required',
            'tipo' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);    
        }

        $permiso = Configuracion::create($request->all());

        return response()->json([
            'status' => true,
            'data' => $permiso,
            'msg' => $permiso->name.' creado!'
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
        //Updating Role
        $permiso = Configuracion::findOrFail($id);

        $permiso->fill($request->all());

        return response()->json([
            'status' => TRUE,
            'data' => $permiso,
            'msg' => $permiso->name.' actualizado!'
        ]);
    }

    /**
     * @param  Toma el id de un Rol y lo elimina con sus respectivos permisos
     */
    public function destroy($id, Request $request)
    {
        $permiso = Configuracion::find($id);
        $permiso->delete();

        return response()->json([
            'status'=>TRUE,
            'id' =>$id,
            'msg' => $permiso->name.' eliminado!'
        ]);
    }

            
    /**
     * Devuelve TRUE si el campo esta disponible
     */
    public function isUniqueField($field, Request $request){
        $existe = Configuracion::where($field,$request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe==0),
            'msg' =>  $request->value. ($existe!=0 ? ' ya esta siendo utilizado por otro rol' : ' esta disponible')
        ]);
    }

    /**
     * Devuelve el listado de configuraciones generales del sistema
     */
    public function mainSettings(){
        $settings = [
            'company_name' => Configuracion::valor('company_name'),
            'company_shortname' => Configuracion::valor('company_shortname'),
            'slogan' => Configuracion::valor('slogan'),
            'logo' => Configuracion::valor('logo'),
            'telefono' => Configuracion::valor('telefono'),
            'email' => Configuracion::valor('email'),
            'direccion' => Configuracion::valor('direccion'),
        ];

        return response()->json($settings);
    }
}
