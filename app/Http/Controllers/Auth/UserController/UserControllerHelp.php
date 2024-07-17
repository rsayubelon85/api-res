<?php

namespace App\Http\Controllers\Auth\UserController;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\RoleRepository;

class UserControllerHelp extends Controller{
    public function assignRoleUser(User $user,UserRequest $request,RoleRepository $roleRepository){
        $roles_id = explode(',', $request->input('roles'));//Pica la cadena

        $roles = $roleRepository->whereIn('roles.id',$roles_id)->get();

        if ($roles) {
            $user->syncRoles($roles);
            return true;
        }
        return false;
    }
}

