<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Trace extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'permission_id',
		'created_object',
		'object_before_modify',
		'modified_object',
		'delete_object',
		'description',
	];

	//Relacion uno a muchos una sola es asignada a un solo usuario
	public function User()
	{
		return $this->belongsTo('\App\Models\User\User');
	}

	//Relacion uno a muchos una sola es asignada a un solo usuario
	public function Permission()
	{
		return $this->belongsTo('\Spatie\Permission\Models\Permission');
	}
}
