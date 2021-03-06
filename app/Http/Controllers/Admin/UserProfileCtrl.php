<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileCtrl extends Controller
{
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $usuario = User::find(Auth::user()->id);

        $usuario->fill($request->except(['avatar']));
        
        if($request->has('avatar') && !is_null($request->avatar))
        {
            $usuario->avatar = parent::uploadAvatar($request->avatar,'/images/profiles/');
        }

        $info = UserInfo::firstOrNew([
            'id' => $usuario->id
        ]);
        
        $info->fill($request->user_info);
        
        unset($info->portada);
        if($request->has('portada') && !is_null($request->portada))
        {
            $info->portada = parent::uploadAvatar($request->portada,'/images/profiles/');
        }
        
        $info->save();

        $usuario->save();

        //TODO::añadir solo si se esta editando desde el perfil del usuario
        $usuario->ability = $usuario->allPermissions;

        return response()->json([
            'status' => true,
            'data' => $usuario,
            'msg' => $usuario->username.' actualizado!'
        ]);
    }

    
    public function updatePassword(Request $request){

        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(),[
            'old_password'          => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);    
        }

        if (Hash::check($request->old_password, $user->password)) {
        
            $user->password = Hash::make($request->password);
            $user->save();
        }else{
            return response()->json([
                'status' => false,
                'data' => $user,
                'msg' => 'Contraseña antigua incorrecta!'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $user,
            'msg' => $user->username.' actualizado!'
        ]);
     
    }
}
