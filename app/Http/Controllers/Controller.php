<?php

namespace App\Http\Controllers;

use App\Models\Trace;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function Insert_Trace(string $name_permiso, string $obj_creado, string $obj_antes_modificar, string $obj_modificado, string $obj_eliminado, string $descripcion)
    {
        $current_user = Auth()->user();
        if ($current_user == null) {
            $current_user = User::find(1);
        }
        $trace = new Trace();
        $trace->user_id = $current_user->id;
        $permission = Permission::where('name', $name_permiso)->first();
        $trace->permission_id = $permission->id;

        $obj_creado != 'null' ? $trace->created_object = $obj_creado : $trace->created_object = null;
        $obj_antes_modificar != 'null' ? $trace->object_before_modify = $obj_antes_modificar : $trace->object_before_modify = null;
        $obj_modificado != 'null' ? $trace->modified_object = $obj_modificado : $trace->modified_object = null;
        $obj_eliminado != 'null' ? $trace->delete_object = $obj_eliminado : $trace->delete_object = null;

        $trace->description = $descripcion;

        $trace->save();
    }
}
