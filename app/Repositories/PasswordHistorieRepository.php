<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Password_historie;
use Illuminate\Support\Facades\DB;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class PasswordHistorieRepository.
 */
final class PasswordHistorieRepository extends BaseRepository
{
	protected $model;

	public function __construct(Password_historie $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		return DB::transaction(function () use ($data) {
			return $this->model->create($data);
		});
	}

	public function getPasswordByUser($id)
	{
		return DB::transaction(function () use ($id) {
			return $this->model::query('user_id', $id)->get();
		});
	}

	public function remove(Password_historie $userPassword)
	{
		return DB::transaction(function () use ($userPassword) {
			if ($userPassword) {
				$this->delete();

				return true;
			}

			return false;
		});
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
