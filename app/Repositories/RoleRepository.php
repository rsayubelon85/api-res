<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Spatie\Permission\Models\Role;

//use Your Model

/**
 * Class RoleRepository.
 */
final class RoleRepository extends BaseRepository
{
	protected $model;

	public function __construct(?Role $model = null)
	{
		$this->model = $model ?? new Role();
	}

	public function getRolTable()
	{
		return datatables()->eloquent(Role::query())
			->addColumn('action', 'actions')
			->toJson();
	}

	public function getPermissions($id)
	{
		return $this->model->find($id)->permissions();
	}

	public function getRoleDiferentId($id)
	{
		return $this->model::query('id', '<>', $id)->get();
	}

	public function create(array $data)
	{
		return DB::transaction(function () use ($data) {
			return $this->model->create($data);
		});
	}

	public function update(Role $role)
	{
		return DB::transaction(function () use ($role) {
			if ($role) {
				$role->touch();

				return $role;
			}

			return null;
		});
	}

	public function remove(Role $role)
	{
		return DB::transaction(function () use ($role) {
			if ($role) {
				$this->deleteById($role->id);

				return true;
			}

			return false;
		});
	}

	public function hasUsersAssigned(Role $role)
	{
		return $role->users()->count();
	}

	public function hasPermissionsAssigned(Role $role)
	{
		return $role->permissions()->count();
	}

	/**
	 * @return string
	 *  Return the model
	 */
	public function model()
	{
		return Role::class;
	}

    public function getRoleName(){
        return $this->model->pluck('name');
    }
}
