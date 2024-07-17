<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

final class RoleController extends Controller
{
	private RoleRepository $roleRepository;

	public function __construct(RoleRepository $roleRepository)
	{
		$this->middleware('can:rol.admin')->only('roles', 'index', 'store', 'edit', 'update', 'destroy');

		$this->roleRepository = $roleRepository;
	}

	public function roles()
	{
		Session::put('TypeController', 'Role');
		return $this->roleRepository->getRolTable();
	}

	public function index()
	{
		$roles = $this->roleRepository->all();
		return response()->json($roles);
	}

	public function store(RoleRequest $request)
	{
        try {
            $role = $this->roleRepository->create(['name' => $request['name']]);

            $this->Insert_Trace('rol.admin', json_encode($role), 'null', 'null', 'null', 'Se creo el rol.');

            $token = auth()->user()->createToken('Token')->accessToken;

            return response()->json(['token' => $token, 'status' => 'El rol fue registrado correctamente.'], 200);

        } catch (ModelNotFoundException $e) {
            reportException($e);

            return response()->error('Default role Id don\'t exist, please change in Defaults Module');
        } catch (\Exception $e) {
            reportException($e);

            return response()->error('An error occurred, please try again');
        }
	}

	public function edit(Role $role)
	{
		return response()->json($role);
	}

	public function update(RoleRequest $request, Role $role)
	{
        try {
            $role->name = $request['name'];
            $roleNew = $this->roleRepository->update($role);

            $this->Insert_Trace('rol.admin', 'null', json_encode($role), json_encode($roleNew), 'null', 'Se modificó el rol');

            $token = auth()->user()->createToken('Token')->accessToken;

            return response()->json(['token' => $token, 'status' => 'El rol fue editado correctamente.'], 200);
        } catch (ModelNotFoundException $e) {
            reportException($e);

            return response()->error('Default role Id don\'t exist, please change in Defaults Module');
        } catch (\Exception $e) {
            reportException($e);

            return response()->error('An error occurred, please try again');
        }
	}

	public function destroy(Role $role)
	{
        try {
            if ($this->roleRepository->hasUsersAssigned($role) > 0) {
                $message = 'El rol no se puede eliminar porque está asignado a un usuario.';
            } elseif ($this->roleRepository->hasPermissionsAssigned($role) > 0) {
                $message = 'El rol no se puede eliminar porque tiene asignado permisos.';
            } else {
                $this->roleRepository->remove($role);

                $this->Insert_Trace('rol.admin', 'null', 'null', 'null', json_encode($role), 'Se eliminó el rol.');

                $message = 'El rol fue eliminado correctamente.';
            }

            $token = auth()->user()->createToken('Token')->accessToken;

            return response()->json(['token' => $token, 'status' => $message], 200);
        } catch (ModelNotFoundException $e) {
            reportException($e);

            return response()->error('Default customer Id don\'t exist, please change in Defaults Module');
        } catch (\Exception $e) {
            reportException($e);

            return response()->error('An error occurred, please try again');
        }
	}
}
