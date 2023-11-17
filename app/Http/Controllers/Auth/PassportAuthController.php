<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    public function login(Request $request){

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //dd($credentials);

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
