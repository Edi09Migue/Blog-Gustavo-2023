<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Usuarios extends Controller
{
    var $datos= [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //Filtros para usuarios
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? $request->sortDesc : true;
        
        //Obtengo los usuarios filtrados y ordenados
        
        $usuarios = User::where('email','like',"%$query%")
                        ->orderBy($sortBy,$sortDesc?'desc':'asc')
                        ->paginate($request->perPage);

        $usuarios->each(function($u){
            $u->avatar = $u->avatarURL;
        });
        
        return response()->json([
            'users' => $usuarios->items(),
            'total'=>$usuarios->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
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
            if($request->has('avatar') && !is_null($request->avatar))
            {
                $usuario->avatar = parent::uploadAvatar($request->avatar,'avatar_'.$request->username,'/images/profiles/');
            }
            $usuario->save();

            $info = new UserInfo([
                'id' => $usuario->id,
            ]);
            $info->fill($request->all());
            $info->save();
            
            if ($request->has('role')) {
                $usuario->assignRole($request->role);
                //$usuario->syncRoles($request->roles_id);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $usuario,
                'msg' => $usuario->username.' creado!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'msg' => 'Error al crear usuario!'
            ]);
        }
    }
    
    /**
     * Devuelve TRUE si el Username esta disponible
     */
    public function isUniqueUsername(Request $request){
        $existe = User::where('username',$request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe==0),
            'msg' =>  $request->value. ($existe!=0 ? ' ya esta siendo utilizado por otro usuario' : ' esta disponible')
        ]);
    }
    
    /**
     * Devuelve TRUE si el Email esta disponible
     */
    public function isUniqueEmail(Request $request){
        $existe = User::where('email',$request->value)->count();
        return response()->json([
            'status' => true,
            'valid' => ($existe==0),
            'msg' => $request->value. ($existe!=0 ? ' ya esta siendo utilizado por otro usuario' : ' esta disponible')
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
        $usuario->userInfo;
        return response()->json($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkpointReward($id)
    {
        
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
        $usuario->fill($request->all());
        
        if($request->has('password')){
            $usuario->password = bcrypt($request->password);
        }
        
        //$usuario->persona->fill($request->all('persona')['persona']);
        
        // if($request->has('avatar') && !is_null($request->avatar))
        // {
        //     $usuario->persona->avatar = parent::uploadAvatar($request->avatar,'avatar_'.$usuario->username,'/images/profiles/');
        //     $usuario->persona->save();
        // }

        $info = UserInfo::firstOrNew([
            'id' => $usuario->id
        ]);
        
        $info->fill($request->user_info);
        $info->save();

        if ($request->has('rol')) {
            $usuario->syncRoles([$request->rol]);
        }
        //$persona->save();
        $usuario->save();

        return response()->json([
            'status' => true,
            'data' => $usuario,
            'msg' => $usuario->username.' actualizado!'
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
        return response()->json(['success'=>TRUE,'id'=>$id]);
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
        $usuario->estado="desactivo";
        $usuario->save();
        return response()->json(['success'=>TRUE,'id'=>$id]);
    }
}
