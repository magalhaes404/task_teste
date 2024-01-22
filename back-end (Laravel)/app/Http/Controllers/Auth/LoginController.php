<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request){
        $validator = validator($request->all(), [
            'email'            =>  'required|email',
            'password'         =>  'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()],406);
        } else {
            $user = User::where('email',$request->email)->first();
            if($user != null){
                if (Hash::check($request->password,$user->password)) {
                    $token = $user->createToken('default');
                    return response()->json(['token' => $token->plainTextToken], 250);
                }
            }
            return response()->json(['message' => 'erro ao autenticar'],401);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Desconectado'],250);
    }

    public function me(Request $request){
        $user = $request->user();
        return [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
