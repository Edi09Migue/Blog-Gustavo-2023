<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Models\Inscrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Inscritos extends Controller
{
    var $datos;

    /**
     * Devuelve el listado de permisos paginados
     */
    public function index(Request $request)
    {
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : "true";


        $inscritos = Inscrito::with(['parroquia.canton','candidato'])
        ->where('nombre', 'like', "%$query%")
        ->orderBy($sortBy, $sortDesc == "true" ? 'desc' : 'asc')
        ->paginate($perPage);


        return response()->json([
            'items' => $inscritos->items(),
            'total' => $inscritos->total()
        ]);
    }

    /**
     * Devuelve el id, nombre y grupo de todos los permisos 
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $inscritos = Inscrito::select('id', 'nombre', 'telefono')->get();

        return response()->json($inscritos);
    }

    /**
     * Devuelve el id, nombre y grupo de todos los permisos 
     * por lo general para usarlos en un componente dropdown
     */
    public function misInscritos()
    {
        $id = Auth::user()->id;

        $inscritos = Inscrito::with('parroquia.canton')
                    ->where('candidato_id', $id)
                    ->orderBy('created_at','desc')
                    ->get();

        return response()->json($inscritos);
    }

    /**
     * Crea un Permiso
     * @param  Request
     * @return [type]
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'parroquia_id' => 'required',
            'telefono' => 'required|unique:inscritos'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        $inscrito = new Inscrito($request->all());
        $inscrito->candidato_id = Auth::user()->id;
        $inscrito->creado_por = Auth::user()->id;
        $inscrito->save();
        

        return response()->json([
            'status' => true,
            'data' => $inscrito,
            'msg' => $inscrito->name . ' creado!'
        ]);
    }

    /**
     * Editar  permiso
     * @param  [integer] 
     * @param  Request
     * @return [type]
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'guard_name' => 'required',
            'telefono' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        //Updating Permiso
        $inscrito = Inscrito::findOrFail($id);

        $inscrito->update($request->all());

        return response()->json([
            'status' => TRUE,
            'data' => $inscrito,
            'msg' => $inscrito->name . ' actualizado!'
        ]);
    }

    /**
     * @param  Toma el id de un Permiso y lo elimina 
     */
    public function destroy($id, Request $request)
    {
        $inscrito = Inscrito::find($id);
        $inscrito->delete();

        return response()->json([
            'status' => TRUE,
            'id' => $id,
            'msg' => $inscrito->name . ' eliminado!'
        ]);
    }



    /**
     * Devuelve TRUE si el campo esta disponible
     */
    public function isUniqueField($field, Request $request)
    {
        $existe = Inscrito::where($field, $request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe == 0),
            'msg' =>  $request->value . ($existe != 0 ? ' ya esta siendo utilizado por otro permiso' : ' esta disponible')
        ]);
    }
}
