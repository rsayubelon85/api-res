<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\PaiseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

final class UserController extends Controller
{
	private $userRepository;
	private $paiseRepository;
	//private $rolRepository;
	//private $historyRepository;

	public function __construct(UserRepository $userRepository, PaiseRepository $paiseRepository/*, RolRepository $rolRepository, PasswordHistorieRepository $historyRepository*/)
	{
		//$this->middleware('auth');
		$this->userRepository = $userRepository;
		$this->paiseRepository = $paiseRepository;
		/*$this->rolRepository = $rolRepository;
		$this->historyRepository = $historyRepository;*/
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$users = $this->userRepository->all();
		return response()->json($users);
	}

	public function store(UserRequest $request)
	{
		$nationality = null;
		if ($request->$nationality !== null) {
			$paise = $this->paiseRepository->getByColumn(['code']);//Paise::where('code',$request->$nationality)->first();
			if ($paise !== null) {
				$nationality = $paise->name;
			}
		}
		$user = User::create([
			'name' => $request->name,
			'last_name' => $request->last_name,
			'username' => $request->username,
			'age' => $request->age,
			'sex' => $request->sex,
			'email' => $request->email,
			'nationality' => $nationality,
			'password' => Hash::make($request->password),
		]);

		$token = $user->createToken('Token')->accessToken;

		/*$idRol = $request['roles'][0];
		$rol = $this->rolRepository->getById($idRol);
		$user->assignRole($rol);

		$this->historyRepository->create([
			'user_id' => $user->id,
			'password' => $password,
		]);*/

		/*$message = $this->Mensaje('success', 'Información!', 'El usuario ha sido registrado correctamente.', true);
		$this->Insertar_Traza('rol.admin', json_encode($user), 'null', 'null', 'null', 'Se creo el usuario.');*/


		return response()->json(
			['token' => $token, 'status' => 'success'],
			200
		);
	}

	public function edit(User $user)
	{
		return response()->json($user);
	}

	public function update(Request $request, User $user)
	{
		if ($request->password === null) {
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
		} else {
			$request->validate([
				'password' => [
					'required',
					Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),
				],
				'password_confirmation' => 'required|same:password',
			]);

			$user->password = Hash::make($request->password);
		}

		$user->touch();

		$token = $user->createToken('Token')->accessToken;
		dd('guardar');
		return response()->json(['token' => $token, 'status' => 'success'], 200);
	}

	public function destroy(User $user)
	{
		//return 'Bienvenido a eliminar';
		$user->delete();

		$token = $user->createToken('Token')->accessToken;

		return response()->json(['token' => $token, 'status' => 'success'], 200);
	}
}
