<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Countrie;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class CountryRepository.
 */
final class CountryRepository extends BaseRepository
{
	protected $model;

	public function __construct(Countrie $model = null)
	{
		$this->model = $model === null ? new Countrie() : $model;
	}

	public function model()
	{
		// TODO: Implement model() method.
	}
}
