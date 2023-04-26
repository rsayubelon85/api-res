<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class PassportAuthController extends Controller
{
    public function register(UserRequest $request){
        $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'age' => $request['sex'],
            'sex' => $request['age'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken('Token')->accessToken();

        return response()->json(['token' => $token],200);

    }

    public function login(Request $request){
        $credentials = [
            'email' => $request->email,
            'passport' => $request->passport
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Token')->accessToken;

            return response()->json(['token' => $token],200);
        }
        else{
            return response()->json(['error' => 'Credenciales erroneas']);
        }

        
    }

    public function logout (Request $request){

        $token = auth()->user()->token();

        $token->revoke();

        return response()->json(['success' => 'Logout successfully']);
        
    }
}
