<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Configuraciones extends Controller
{
    var $datos;

    /**
     * Devuelve el listado de configuraciones paginado
     */
    public function index(Request $request){
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 50;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : "true";

        
        $configuraciones = Configuracion::where('key','like',"%$query%")
                        ->orderBy($sortBy,$sortDesc=="true"?'desc':'asc')
                        ->paginate($perPage);

        //Genero el campo imageUrl para las configuraciones de tipo 'image'
    	$configuraciones->filter(function($c){ return $c->tipo=="image";})
                        ->each(function($c){$c->imageUrl= $c->imageUrl;});

    	return response()->json([
            'items' => $configuraciones->items(),
            'total' => $configuraciones->count()
        ]);
    }
    
    /**
     * Crea una variable de configuracion
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
     * Actualiza un grupo de configuraciones
     * @param  [string] 
     * @param  Request
     * @return [type]
     */
    public function update($grupo, Request $request)
    {
        switch($grupo){
            case 'correo':
                $valores = $request->only([
                    'servidor_smtp','user_smtp','password_smtp',
                    'puerto_smtp','encryption_smtp',
                ]);
                //Sobre-escribo el archivo de configuraciones del mail
                Config::set('mail.mailers.smtp.host', $request->servidor_smtp);
                Config::set('mail.mailers.smtp.username', $request->user_smtp);
                Config::set('mail.mailers.smtp.password', $request->password_smtp);
                Config::set('mail.mailers.smtp.port', $request->puerto_smtp);
                Config::set('mail.mailers.smtp.encryption', $request->encryption_smtp);
            
            break;
            case 'general':
                $valores = $request->only([
                    'company_name','company_shortname','slogan',
                    'ruc','email','telefono','fax','direccion',
                    'facebook_url','twitter_url','instagram_url'
                ]);

                if($request->has('logo') && !is_null($request->logo))
                {
                    $img_url = parent::uploadAvatar($request->logo,'/images/uploads/');
                    $valores['logo'] = $img_url;
                }

                break;
            case 'sistema':
                $valores = $request->only([
                    'formato_fecha','iva','decimales',
                    'idioma','en_mantenimiento',
                ]);
                break;
            default:
            $valores=[];
            break;
        }

        foreach($valores as $key => $value){
            $setting = Configuracion::where('key',$key)->first();

            $setting->value = $value;

            $setting->save();
        }

        return response()->json([
            'status' => TRUE,
            'data' => count($valores).' configuraciones',
            'msg' => 'Configs actualizadas!'
        ]);
    }

    /**
     * @param  Toma el id de un Rol y lo elimina con sus respectivos configuraciones
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
