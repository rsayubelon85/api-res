<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'age' => $request['sex'],
            'sex' => $request['age'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return redirect('/users');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('auth.user.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if($request['password'] == null){
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number,'.$user->id,
            ]);
        }
        else {
            $request->validate([
                'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
                'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number,'.$user->id,
                'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
                'password_confirmation' => 'required|same:password'
            ]);

            $user->password = Hash::make($request['password']);
        }
        $user->name = $request['name'];
        $user->last_name = $request['last_name'];
        $user->sex = $request['sex'];
        $user->age = $request['age'];
        $user->touch();

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users');
    }
}
