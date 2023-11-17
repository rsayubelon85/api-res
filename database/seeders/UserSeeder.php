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
        $rol1 = Role::create(['name' => 'Administrador']);
        $rol2 = Role::create(['name' => 'Facturador']);
        $rol3 = Role::create(['name' => 'Invitado']);

        $user1 = User::create([ 'name' => 'Reynier','last_name' => 'Sayu Belon','age' => '38','sex' => 'M','username' => 'rsayu','email' => 'rsayubelon85@gmail.com', 'countrie_id' => 54,'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi'])->assignRole($rol1); // Rsb*123456
        $user2 = User::create(['name' => 'Andres','last_name' => 'Sayu Belon','age' => '35', 'sex' => 'M', 'username' => 'asayu', 'email' => 'asayu@nauta.cu', 'countrie_id' => 54, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi'])->assignRole($rol2); // Rsb*123456
        $user3 = User::create(['name' => 'Imara','last_name' => 'García Hernandez','age' => '38', 'sex' => 'F', 'username' => 'imagimg', 'email' => 'imagimg@nauta.cu', 'countrie_id' => 54, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi'])->assignRole($rol3); // Rsb*123456

        Permission::create(['name' => 'rol.admin', 'real_name' => 'Permiso de Administración'])->syncRoles($rol1);
        Permission::create(['name' => 'user.edit_user_perfil', 'real_name' => 'Editar Perfil de Usuario'])->syncRoles([$rol1, $rol2, $rol3]);
        Permission::create(['name' => 'user.show_order', 'real_name' => 'Mostrar Orden de Usuario'])->syncRoles([$rol1, $rol2, $rol3]);
        Permission::create(['name' => 'register.user', 'real_name' => 'Registrar Usuario'])->syncRoles([$rol1, $rol2, $rol3]);

        Password_historie::create(['user_id' => $user1->id, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi']);
        Password_historie::create(['user_id' => $user2->id, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi']);
        Password_historie::create(['user_id' => $user3->id, 'password' => '$2y$10$O7JjZ2fuMtPU79vyNQN.eeeloNFo8CjGu/y7N6OvKx2C3O0obXMBi']);
    }
}
