<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Paise;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class PaiseRepository.
 */
final class PaiseRepository extends BaseRepository
{
	protected $model;

	public function __construct(Paise $model = null)
	{
		$this->model = $model === null ? new User() : $model;
	}

	public function model()
	{
		// TODO: Implement model() method.
	}
}
