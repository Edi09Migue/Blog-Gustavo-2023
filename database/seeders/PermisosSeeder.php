<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'admin']);
        $cliente = Role::create(['name' => 'cliente']);
        $autor = Role::create(['name' => 'autor']);
        $editor = Role::create(['name' => 'editor']);
        $suscriptor = Role::create(['name' => 'suscriptor']);

        //
        $p_listar_configs = Permission::create(['name' => 'manage','group_key'=>'Generales']);

        //Configuraciones
        $p_listar_configs = Permission::create(['name' => 'listar-configs','group_key'=>'Generales']);
        $p_crear_configs = Permission::create(['name' => 'crear-configs','group_key'=>'Generales']);       
        $p_editar_configs = Permission::create(['name' => 'editar-configs','group_key'=>'Generales']);       
        $p_eliminar_configs = Permission::create(['name' => 'eliminar-configs','group_key'=>'Generales']);  

        //Seguridad
        $p_listar_usuarios = Permission::create(['name' => 'listar-usuarios','group_key'=>'Seguridad']);
        $p_crear_usuarios = Permission::create(['name' => 'crear-usuarios','group_key'=>'Seguridad']);
        $p_editar_usuarios = Permission::create(['name' => 'editar-usuarios','group_key'=>'Seguridad']);
        $p_eliminar_usuarios = Permission::create(['name' => 'eliminar-usuarios','group_key'=>'Seguridad']);

        $p_listar_roles = Permission::create(['name' => 'listar-roles','group_key'=>'Seguridad']);
        $p_crear_roles = Permission::create(['name' => 'crear-roles','group_key'=>'Seguridad']);
        $p_editar_roles = Permission::create(['name' => 'editar-roles','group_key'=>'Seguridad']);
        $p_eliminar_roles = Permission::create(['name' => 'eliminar-roles','group_key'=>'Seguridad']);

        $p_listar_permisos = Permission::create(['name' => 'listar-permisos','group_key'=>'Seguridad']);
        $p_crear_permisos = Permission::create(['name' => 'crear-permisos','group_key'=>'Seguridad']);
        $p_editar_permisos = Permission::create(['name' => 'editar-permisos','group_key'=>'Seguridad']);
        $p_eliminar_permisos = Permission::create(['name' => 'eliminar-permisos','group_key'=>'Seguridad']);

        $permisos = Permission::all();
        foreach ($permisos as $key => $permiso) {
            $superadmin->givePermissionTo($permiso);
            $admin->givePermissionTo($permiso);
        }

        $user_superadmin = User::find(1);
        $user_superadmin->assignRole('admin');

    }
}
