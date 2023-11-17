<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Password_historie extends Model
{
	use HasFactory;

	protected $fillable = ['user_id', 'password'];

	protected $hidden = ['created_at', 'updated_at', ];

	//Relacion uno a muchos un historial de contraseña solo es asignado a un solo usuario
	public function User()
	{
		return $this->belongsTo('\App\Models\User');
	}
}
