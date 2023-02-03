<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsuariosExport;
use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\Configuracion;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class Usuarios extends Controller
{
    var $datos = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        //Filtros para query
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc == "true" ? true : false) : false;

        //Obtengo una instancia de Usuarios para el query
        $usuarios = User::with('userInfo');

        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if ($estado != '') {
            $usuarios = $usuarios->where('estado', $estado);
        }
        //Filtro para Rol
        $role = $request->has('role') ? $request->role : '';
        if ($role != '') {
            $usuarios = $usuarios->where(function ($q) use ($role) {
                $q->whereIn('id', function ($sq) use ($role) {
                    $sq->select('model_id');
                    $sq->from('model_has_roles');
                    $sq->where('role_id', $role);
                });
            });
        }

        //Filtros basicos, orden y paginacion
        $usuarios = $usuarios->where(function ($q) use ($query) {
            $q->where('email', 'like', "%$query%")
                ->orWhere('name', 'like', "%$query%")
                ->orWhere('username', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        $usuarios->each(function ($u) {
            $u->avatar = $u->avatarURL;
        });

        Log::info(DB::getQueryLog());
        return response()->json([
            'items' => $usuarios->items(),
            'total' => $usuarios->total()
        ]);
    }


    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las cantones
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions(Request $request)
    {
        $candidadtos = User::query();

        // //en caso de querer solo los cantones de una provincia
        // if ($request->has('gid1'))
        // $candidadtos = $candidadtos->where('gid1', $request->gid1);

        $candidadtos = $candidadtos->conRol('candidato')->get();

        return response()->json($candidadtos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required',
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

            $usuario = new User($request->all());
            $usuario->password = bcrypt($request->password);
            $usuario->save();
            if ($request->has('avatar') && !is_null($request->avatar)) {
                //Path donde se va a subir el archivo
                $upload_folder = '/images/profiles/';
                //Subo la imagen en base 64 y la asigno como 'Mediable'
                parent::uploadAndConvert($request->avatar, $upload_folder, $usuario, 'main', 'name');
            }

            $info = new UserInfo([
                'id' => $usuario->id,
            ]);
            $info->fill($request->all());
            $info->save();

            if ($request->has('role')) {
                $usuario->assignRole($request->role); //asigno un solo rol
                //$usuario->syncRoles($request->roles_id);//asigno varios roles
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $usuario,
                'msg' => $usuario->username . ' creado!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $e->getMessage(),
                'msg' => 'Error al crear usuario!'
            ]);
        }
    }

    /**
     * Devuelve TRUE si el Username esta disponible
     */
    public function isUniqueUsername(Request $request)
    {
        $existe = User::where('username', $request->value)->count();
        //$existe = User::whereRaw("BINARY `username`= ?", [$request->value])->count();

        return response()->json([
            'status' => true,
            'valid' => ($existe == 0),
            'msg' =>  $request->value . ($existe != 0 ? ' ya esta siendo utilizado por otro usuario' : ' esta disponible')
        ]);
    }

    /**
     * Devuelve TRUE si el Email esta disponible
     */
    public function isUniqueEmail(Request $request)
    {
        $existe = User::where('email', $request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe == 0),
            'msg' => $request->value . ($existe != 0 ? ' ya esta siendo utilizado por otro usuario' : ' esta disponible')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        //$usuario->portadaURL = $usuario->imageURL('portada');
        $usuario->userInfo;
        $usuario->permisos = $usuario->getAllPermissions();
        $usuario->notifications;
        return response()->json($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $usuario = User::find($id);

        $usuario->fill($request->except(['avatar']));

        if ($request->has('password')) {
            $usuario->password = bcrypt($request->password);
        }

        if ($request->has('avatar') && !is_null($request->avatar)) {
            //Path donde se va a subir el archivo
            $upload_folder = '/images/profiles/';
            //Subo la imagen en base 64 y la asigno como 'Mediable'
            parent::uploadAndConvert($request->avatar, $upload_folder, $usuario, 'main', 'name');
        }

        if ($request->has('user_info')) {
            $info = UserInfo::firstOrNew([
                'id' => $usuario->id
            ]);
            $info->fill($request->user_info);
            $info->save();
        }

        if ($request->has('role')) {
            $usuario->syncRoles([$request->role]);
        }
        $usuario->save();

        return response()->json([
            'status' => true,
            'data' => $usuario,
            'msg' => $usuario->username . ' actualizado!'
        ]);
    }

    /**
     * Actualiza la contraseña de un usuario
     */
    public function updatePassword(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        $usuario = User::find($id);

        $usuario->password = Hash::make($request->password);

        $usuario->save();

        return response()->json([
            'status' => true,
            'data' => $usuario,
            'msg' => $usuario->username . ' actualizado!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $usuario = User::find($id);
        $usuario->delete();
        return response()->json(['status' => TRUE, 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id, Request $request)
    {
        $usuario = User::find($id);
        $usuario->estado = User::STATUS_INACTIVO;
        $usuario->save();
        return response()->json(['status' => TRUE, 'id' => $id]);
    }

    /**
     * Sube un archivo en excel y los importa a la tabla usuarios
     */
    public function importExcel(Request $request)
    {
        if (!$request->has('documento')) {
            return response()->json([
                'status' => FALSE,
                'errors' => 'El documento no se adjunto'
            ]);
        }
        $filename = $request->documento->store('imports/users/');

        try {
            $resultado = Excel::import(new UsersImport, $filename);
            $resultado = (new UsersImport)->toCollection($filename);

            if (count($resultado) > 0) {
                $resultado = $resultado[0];
            }

            return response()->json(['success' => TRUE, 'items' => $resultado]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                return response()->json([
                    'success' => FALSE,
                    'row' => $failure->row(), // row that went wrong
                    'attribute' => $failure->attribute(), // either heading key (if using heading row concern) or column index
                    'errors' => $failure->errors(), // Actual error messages from Laravel validator
                    'values' => $failure->values(), // The values of the row that has failed.
                ]);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'success' => FALSE,
                'errors' => $e
            ]);
        }
    }

    /**
     * Devuelve los reportes de usuarios con los siguientes filtros opcionales
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
        $vista_reporte = "back.admin.usuarios.reporte_full";

        //Si se require un formato especifico (pdf,xlsx,view)
        $formato = $request->has('formato') ? $request->formato : "pdf"; //por defecto va pdf

        $nombre_reporte = "Reporte de Usuarios, $tipo";

        //Si se especifica un intervalo de fechas
        if ($request->has('desde') && $request->has('hasta')) {
            $desde = $request->desde;
            $hasta = $request->hasta;
            $nombre_reporte .= " ({$desde} - {$hasta})";
        }

        //envio los parametros al modelo para que solo me devuelva
        // los que cumplan las condiciones recibidas en $request
        $usuarios = User::paraReporte($request);



        $datos_reporte = [
            'titulo'        => $nombre_reporte,
            'usuarios'   => $usuarios,
            'tipo'          => $tipo,
            'desde'         => @$desde,
            'hasta'         => @$hasta,
        ];

        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $storagePath .= 'reportes\\';
        $file_name = "Reporte Usuarios, $tipo" . date('dmY');

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
                return Excel::download(new UsuariosExport($request), $file_name . '.xlsx');
                break;
            default: //Devolvemos la vista en HTML
                return view($vista_reporte, $datos_reporte);
                break;
        }
    }
}