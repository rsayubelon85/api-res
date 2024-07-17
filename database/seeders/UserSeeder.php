<?php

namespace Database\Seeders;

use App\Models\Password_historie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador', 'guard_name' =>'api']);
        $role2 = Role::create(['name' => 'Facturador', 'guard_name' =>'api']);
        $role3 = Role::create(['name' => 'Invitado', 'guard_name' =>'api']);

        Permission::create(['name' => 'rol.admin', 'real_name' => 'Permiso de Administración', 'guard_name' =>'api']);
        Permission::create(['name' => 'user.edit_user_perfil', 'real_name' => 'Editar Perfil de Usuario', 'guard_name' =>'api']);
        Permission::create(['name' => 'user.show_order', 'real_name' => 'Mostrar Orden de Usuario', 'guard_name' =>'api']);
        Permission::create(['name' => 'register.user', 'real_name' => 'Registrar Usuario', 'guard_name' =>'api']);

        // Assign permissions to roles using givePermissionTo
        $role1->givePermissionTo('rol.admin', 'user.edit_user_perfil', 'user.show_order', 'register.user');
        $role2->givePermissionTo('user.edit_user_perfil', 'user.show_order', 'register.user');
        $role3->givePermissionTo('user.edit_user_perfil', 'user.show_order', 'register.user');

        $user1 = User::create([ 'name' => 'Reynier','last_name' => 'Sayu Belon','age' => '38','sex' => 'M','username' => 'rsayu','email' => 'rsayubelon85@gmail.com', 'countrie_id' => 54,'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi'])->assignRole($role1); // Rsb*123456
        $user2 = User::create(['name' => 'Andres','last_name' => 'Sayu Belon','age' => '35', 'sex' => 'M', 'username' => 'asayu', 'email' => 'asayu@nauta.cu', 'countrie_id' => 54, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi'])->assignRole($role2); // Rsb*123456
        $user3 = User::create(['name' => 'Imara','last_name' => 'García Hernandez','age' => '38', 'sex' => 'F', 'username' => 'imagimg', 'email' => 'imagimg@nauta.cu', 'countrie_id' => 54, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi'])->assignRole($role3); // Rsb*123456


        Password_historie::create(['user_id' => $user1->id, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi']);
        Password_historie::create(['user_id' => $user2->id, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi']);
        Password_historie::create(['user_id' => $user3->id, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi']);
    }
}
