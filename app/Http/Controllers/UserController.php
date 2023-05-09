<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Paise;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(UserRequest $request){

        $nacionalidad = null;
        if($request->nacionalidad != null){
            $nacionalidad = Paise::where('code',$request->nacionalidad)->first();
            if($nacionalidad != null){
                $nacionalidad = $nacionalidad->name;
            }
        }

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'sex' => $request->sex,
            'email' => $request->email,
            'nacionalidad' => $nacionalidad,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('Token')->accessToken;

        return response()->json(['token' => $token,'status' => 'success'],200);

    }

    public function edit(User $user){
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        if($request->password == null){
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'sex' => 'required|string|max:1|regex:([M or F or I]+)',
                'age' => 'required|numeric|max:120',
            ]);

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->sex = $request->sex;
            $user->age = $request->age;
        }
        else {
            $request->validate([
                'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
                'password_confirmation' => 'required|same:password'
            ]);

            $user->password = Hash::make($request->password);
        }
        $user->touch();
        
        $token = $user->createToken('Token')->accessToken;

        return response()->json(['token' => $token,'status' => 'success'],200);
    }

    public function destroy(User $user)
    {
        //return 'Bienvenido a eliminar';
        $user->delete();

        $token = $user->createToken('Token')->accessToken;

        return response()->json(['token' => $token,'status' => 'success'],200);
    }

}
