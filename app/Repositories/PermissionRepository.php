<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Spatie\Permission\Models\Permission;

//use Your Model

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends BaseRepository
{
    protected $model;

    public function __construct(Permission $model = null)
    {
        $this->model = $model == null ? new Permission() : $model;
    }

    public function getByName($name)
    {
        return DB::transaction(function () use ($name) {
            return $this->model->where('name', $name)->first() ?? null;
        });
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });
    }

    public function update(Permission $currency)
    {
        return DB::transaction(function () use ($currency) {
            if ($currency) {
                $currency->touch();

                return $currency;
            }

            return null;
        });
    }

    public function remove(Permission $permission)
    {
        return DB::transaction(function () use ($permission) {
            if ($permission) {
                return $permission->deleteOrFail();
            }
            return false;
        });
    }

    public function getDiferentById($id)
    {
        return $this->model->where('id', '<>', $id)->get();
    }

    public function getPermissionByIds($permissions_int, $id = -1)
    {
        $query = $id == -1
            ? DB::table('permissions')->wherein('id', $permissions_int)
            : DB::table('permissions')->wherein('id', $permissions_int)->orwhere('id', 1);

        $results = $query->get();

        $permissions = [];

        foreach ($results as $result) {
            $permission = new Permission();
            $permission->id = $result->id;
            $permission->name = $result->name;
            $permission->guard_name = $result->guard_name;
            $permission->created_at = $result->created_at;
            $permission->updated_at = $result->updated_at;

            $permissions[] = $permission;
        }

        return $permissions;
    }
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }
}
