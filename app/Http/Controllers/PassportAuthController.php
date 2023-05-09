<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    public function login(Request $request){

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
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
