<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class UserRepository.
 */
final class UserRepository extends BaseRepository
{
	protected $model;

	public function __construct(User $model = null)
	{
		$this->model = $model === null ? new User() : $model;
	}

	public function getUserTable()
	{
		return datatables()->eloquent(User::query())
			->addColumn('action', 'actions')
			->toJson();
	}

	public function getByName($name)
	{
		return $this->model->where('name', $name)->first();
	}

	public function create(array $data)
	{
		return DB::transaction(function () use ($data) {
			return $this->create($data);
		});
	}

	public function update($user)
	{
		return DB::transaction(function () use ($user) {
			if ($user) {
				$user->touch();

				return $user;
			}

			return null;
		});
	}

	public function model()
	{
		// TODO: Implement model() method.
		return $this;
	}

	public function getPaise($code) {}
}
