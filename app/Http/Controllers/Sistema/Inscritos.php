<?php

namespace App\Http\Controllers\Sistema;

use App\Exports\InscritosExport;
use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use App\Models\Inscrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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


        $inscritos = Inscrito::with(['parroquia.canton','candidato']);

        //si no ha seleccionado todos los candidatos
        if ($request->has('candidatos') && !empty($request->candidatos)) {
            $inscritos = $inscritos->whereIn('candidato_id', $request->candidatos);
        }

        //si no ha seleccionado todos los parroquias
        if ($request->has('parroquias') && !empty($request->parroquias)) {
            $inscritos = $inscritos->whereIn('parroquia_id', $request->parroquias);
        }
        

        $inscritos = $inscritos->where('nombre', 'like', "%$query%")
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


    /**
     * Devuelve los reportes de inscritos con los siguientes filtros opcionales
     * - Tipo       (full)
     * - Formato    (pdf,xlsx,view)
     * - Desde      (yyyy-mm-dd)
     * - Hasta      (yyyy-mm-dd)
     */
    public function reportes(Request $request)
    {

        //Si se require un tipo de reporte especial
        $tipo = $request->has('tipo') ? $request->tipo : "full";    //por defecto va completo
        //De acuerdo al tipo seleccionamos la vista con el formato
        $vista_reporte = "back.admin.inscritos.reporte_full";

        //Si se require un formato especifico (pdf,xlsx,view)
        $formato = $request->has('formato') ? $request->formato : "pdf"; //por defecto va pdf

        $nombre_reporte = "Reporte de Inscritos, $tipo";

        //Si se especifica un intervalo de fechas
        if ($request->has('desde') && $request->has('hasta')) {
            $desde = $request->desde;
            $hasta = $request->hasta;
            $nombre_reporte .= " ({$desde} - {$hasta})";
        }

        //envio los parametros al modelo para que solo me devuelva
        // los que cumplan las condiciones recibidas en $request
        $inscritos = Inscrito::paraReporte($request);



        $datos_reporte = [
            'titulo'        => $nombre_reporte,
            'usuarios'   => $inscritos,
            'tipo'          => $tipo,
            'desde'         => @$desde,
            'hasta'         => @$hasta,
        ];

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storagePath .= 'reportes\\';
        $file_name = "Reporte Inscritos, $tipo" . date('dmY');

        //De acuerdo al formato utilizamos la libreria
        switch ($formato) {
            case 'pdf': //Utilizamos el paquete elibyy/tcpdf-laravel
                PDF::SetTitle($nombre_reporte);
                PDF::SetAuthor(Configuracion::valor('company_name'));
                PDF::AddPage('P', 'A4');

                $info = View::make($vista_reporte, $datos_reporte)->render();
                PDF::WriteHTML($info, true, 0, true, 0);
                //F=>Escribir en disco
                //D=>Descargar
                $file = PDF::Output($storagePath . $file_name . ".pdf", 'I');
                return response()->json([
                    'file' => $file,
                    'name' => $file_name . ".pdf"
                ]);
                break;
            case 'xlsx': //Utilizamos el paquete elibyy/tcpdf-laravel
                return Excel::download(new InscritosExport($request), $file_name . '.xlsx');
                break;
            default: //Devolvemos la vista en HTML
                return view($vista_reporte, $datos_reporte);
                break;
        }
    }
}
