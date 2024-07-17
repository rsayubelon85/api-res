<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\UserController;

use App\Http\Controllers\Auth\UserController\UserControllerHelp;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\CountryRepository;
use App\Repositories\PasswordHistorieRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

final class UserController extends UserControllerHelp
{
	private $userRepository;
	private $countryRepository;
	private $roleRepository;
	private $historyRepository;

	public function __construct(UserRepository $userRepository, CountryRepository $countryRepository, RoleRepository $roleRepository, PasswordHistorieRepository $historyRepository)
	{
        $this->middleware('can:rol.admin')->only( 'index', 'store', 'edit', 'update', 'destroy');
		$this->userRepository = $userRepository;
		$this->countryRepository = $countryRepository;
		$this->roleRepository = $roleRepository;
		$this->historyRepository = $historyRepository;
	}
	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$users = $this->userRepository->all();
		return response()->json($users);
	}

	public function store(UserRequest $request): \Illuminate\Http\JsonResponse
    {
        try {

            $password = Hash::make($request->password);

            $user = $this->userRepository->create(array_merge($request->except(['password', 'roles']), ['password' => $password]));

            if (!$this->assignRoleUser($user,$request,$this->roleRepository)) {
                return response()->json(['error' => 'Este rol no existe, por favor escoja otro rol.'], 404);
            }

            $this->historyRepository->create([
                'user_id' => $user->id,
                'password' => $password,
            ]);

            $token = auth()->user()->createToken('Token')->accessToken;

            $this->Insert_Trace('rol.admin', json_encode($user), 'null', 'null', 'null', 'Se creo el usuario.');

            return response()->json(['token' => $token, 'status' => 'El usuario ha sido registrado correctamente.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Este usuario no existe, por favor cambie de usuario.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error en el método store: ' . $e->getMessage());

            return response()->json(['error' => 'Ha ocurrido un error inesperado, por favor intente nuevamente.'], 500);
        }
	}

	public function edit(User $user)
	{
		return response()->json($user);
	}

	public function update(UserRequest $request, User $user)
	{
        try {
            $newPassword = $request['password'];
            if ($newPassword != null) {
                $userHistories = $this->historyRepository->getPasswordByUser($user->id);

                foreach ($userHistories as $userHistory) {
                    if (Hash::check($newPassword, $userHistory->password)) {
                        return response()->json(['error' => 'La contraseña nueva no puede coincidir con ninguna puesta anteriormente, por favor ingrese otra contraseña.'], 404);
                    }
                }
                $user->password = Hash::make($request->password);

                $this->userRepository->update($user,array_merge($request->except(['password', 'roles'])));
            }
            else{
                $this->userRepository->update($user,array_merge($request->except(['password', 'roles'], ['password' => $newPassword])));
            }

            if (!$this->assignRoleUser($user,$request)) {
                return response()->json(['error' => 'Este rol no existe, por favor escoja otro rol.'], 404);
            }

            $token = auth()->user()->createToken('Token')->accessToken;

            return response()->json(['token' => $token, 'status' => 'El usuario ha sido actualizado correctamente.'], 200);
        } catch (ModelNotFoundException $e) {
            messageException($e,'Este usuario no existe, por favor cambie de usuario.');
        } catch (\Exception $e) {
            \Log::error('Error en el método store: ' . $e->getMessage());

            messageException($e,'Ha ocurrido un error inesperado, por favor intente nuevamente.');
        }
	}

	public function destroy(User $user)
	{
        try {
            $this->userRepository->remove($user);

            $token = auth()->user()->createToken('Token')->accessToken;

            return response()->json(['token' => $token, 'status' => 'El usuario fue eliminado correctamente.'], 200);
        } catch (ModelNotFoundException $e) {
            messageException($e,'Este usuario no existe, por favor cambie de usuario.');

        } catch (\Exception $e) {
            \Log::error('Error en el método store: ' . $e->getMessage());

            messageException($e,'Ha ocurrido un error inesperado, por favor intente nuevamente.');

        }

	}
}
