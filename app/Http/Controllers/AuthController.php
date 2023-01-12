<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'username' => 'required|string|unique:users',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'c_password' => 'required|same:password',
        ]);

        $user = new User([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        if ($user->save()) {
            return response()->json([
                'message' => 'Usuario registrado correctamente!'
            ], 201);
        } else {
            return response()->json(['error' => 'Datos incorrectos']);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'status' => false,
                'msg' => 'Correo electrónico o contraseña incorrectos'
            ]);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $user->ability = $user->allPermissions;
        $user->notifications;
        $user->inscritos = $user->inscritos()->count();

        //TODO:: vericar campos adicionales de user
        $user->extras=['eCommerceCartItemsCount'=>0];

        return response()->json([
            'status' => true,
            'accessToken' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'userData' => $user,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Get the authenticated User
    *
    * @return [json] user object
    */
    public function user(Request $request)
    {
        $user = $request->user();
        $user->userInfo;
        $user->allPermissions =$user->allPermissions;
        $user->notifications;

        $user->inscritos = $user->inscritos()->count();
        
        return response()->json($user);
    }

    /**
     * Get the Notifications of authenticated User
    *
    * @return [json] user object
    */
    public function notifications(Request $request)
    {
        $user = $request->user();
        
        $notifications = $user->notifications;

        return response()->json($notifications);
    }

    /**
     * Logout user (Revoke the token)
    *
    * @return [string] message
    */
    public function logout(Request $request)
    {
        if($request->user()->token())
            $request->user()->token()->revoke();
        return response()->json([
            'status'=>true,
            'msg' => 'Sesión finalizada correctamente'
        ]);
    }

    /**
     * Toma el email del formulario de resetear contraseña y envia el email al correo
     * del usuario si existe
     */
    public function resetPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? response()->json(['status' => __($status)])
                    : response()->json(['email' => __($status)]);
    }

    /**
     * Toma el email, la nueva contraseña y el token enviado al correo del usuario
     */
    public function resetPasswordPost(Request $request){

        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);    
        }
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
    
                $user->setRememberToken(Str::random(60));
    
                event(new PasswordReset($user));
            }
        );
    
        return $status == Password::PASSWORD_RESET
                    ? response()->json(['status'=> __($status)])
                    : response()->json(['msg' => [__($status)]]);
    }

    /**
     * Devuelve la vista del email enviado de bienvenida
     */
    public function testWelcomeEmail(){

        $user = User::find(1);

        return (new WelcomeNotification($user))
                    ->toMail($user);
    }

    /**
     * Devuelve la vista del email enviado para restaurar contraseña
     */
    public function testResetPasswordEmail(){

        $user = User::find(1);
        $url = route('password.reset','1234');

        return (new ResetPasswordNotification($url))
                    ->toMail($user);
    }
}
