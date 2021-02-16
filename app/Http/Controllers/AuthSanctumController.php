<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
     /**
    * Create user
    *
    * @param  [string] name
    * @param  [string] email
    * @param  [string] password
    * @param  [string] password_confirmation
    * @return [string] message
    */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email'=>'required|string|unique:users',
            'password'=>'required|string',
            'c_password' => 'required|same:password'
        ]);

        $user = new User([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if($user->save()){
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
            'message' => 'Successfully created user!',
            'accessToken'=> $token,
            ],201);
        }
        else{
            return response()->json(['error'=>'Provide proper details']);
        }
    }

    /**
     * Login user and create token
    *
    * @param  [string] email
    * @param  [string] password
    * @param  [boolean] remember_me
    */

    public function login(Request $request)
    {
        $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
        'remember_me' => 'boolean'
        ]);

        $credentials = request(['email','password']);
        if(!Auth::attempt($credentials))
        {
        return response()->json([
            'message' => 'Unauthorized'
        ],401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        //TODO::definir permisos de usuario
        $abilities = [
            ['action'=>'manage','subject'=>'all']
        ];
        $user->ability = $abilities;

        //TODO::guardar nombre completo
        $user->fullName = $user->name;
        //TODO:: guardar username
        $user->username = $user->name;
        //TODO:: definir rol de usuario
        $user->role = $user->role;

        //TODO:: vericar campos adicionales de user
        $user->extras=['eCommerceCartItemsCount'=>6];

        return response()->json([
            'accessToken' =>$token,
            'userData' => $user,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Get the authenticated User
    *
    * @return [json] user object
    */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user (Revoke the token)
    *
    * @return [string] message
    */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
        'message' => 'Successfully logged out'
        ]);

    }

    /**
     * Refresh User token (Reresh the token)
    *
    * @return [string] message
    */
    public function refreshToken(Request $request)
    {

        $user = auth('sanctum')->user();

        if($user){

            $refreshToken = $request->refreshToken;

            $token = $user->currentAccessToken();

            return response()->json([
                'accessToken' =>$token,
                'userData' => $user,
                'token_type' => 'Bearer',
            ]);
        }else{
            return response()->json([
                'error' => 'Invalid refresh token'
            ],401);
        }


    }


}
