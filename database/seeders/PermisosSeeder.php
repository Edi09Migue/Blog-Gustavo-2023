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
        $p_listar_configs = Permission::create(['name' => 'manage-all', 'group_key' => 'Generales']);
        $p_read_auth = Permission::create(['name' => 'read-Auth', 'group_key' => 'Generales']);

        $p_ver_perfil_user = Permission::create(['name' => 'ver-perfil_user', 'group_key' => 'Generales']);
        $p_editar_perfil_user = Permission::create(['name' => 'editar-perfil_user', 'group_key' => 'Generales']);

        $p_dashboard_user = Permission::create(['name' => 'ver-dashboard_user', 'group_key' => 'Generales']);
        $p_dashboard_editor = Permission::create(['name' => 'ver-dashboard_editor', 'group_key' => 'Generales']);

        //Configuraciones
        $p_listar_configs = Permission::create(['name' => 'listar-configs', 'group_key' => 'Generales']);
        $p_crear_configs = Permission::create(['name' => 'crear-configs', 'group_key' => 'Generales']);
        $p_editar_configs = Permission::create(['name' => 'editar-configs', 'group_key' => 'Generales']);
        $p_eliminar_configs = Permission::create(['name' => 'eliminar-configs', 'group_key' => 'Generales']);

        //Seguridad
        $p_listar_usuarios = Permission::create(['name' => 'listar-usuarios', 'group_key' => 'Seguridad']);
        $p_crear_usuarios = Permission::create(['name' => 'crear-usuarios', 'group_key' => 'Seguridad']);
        $p_editar_usuarios = Permission::create(['name' => 'editar-usuarios', 'group_key' => 'Seguridad']);
        $p_eliminar_usuarios = Permission::create(['name' => 'eliminar-usuarios', 'group_key' => 'Seguridad']);
        $p_importar_usuarios = Permission::create(['name' => 'importar-usuarios', 'group_key' => 'Seguridad']);
        $p_reportes_usuarios = Permission::create(['name' => 'reportes-usuarios', 'group_key' => 'Seguridad']);

        $p_listar_roles = Permission::create(['name' => 'listar-roles', 'group_key' => 'Seguridad']);
        $p_crear_roles = Permission::create(['name' => 'crear-roles', 'group_key' => 'Seguridad']);
        $p_editar_roles = Permission::create(['name' => 'editar-roles', 'group_key' => 'Seguridad']);
        $p_eliminar_roles = Permission::create(['name' => 'eliminar-roles', 'group_key' => 'Seguridad']);

        $p_listar_permisos = Permission::create(['name' => 'listar-permisos', 'group_key' => 'Seguridad']);
        $p_crear_permisos = Permission::create(['name' => 'crear-permisos', 'group_key' => 'Seguridad']);
        $p_editar_permisos = Permission::create(['name' => 'editar-permisos', 'group_key' => 'Seguridad']);
        $p_eliminar_permisos = Permission::create(['name' => 'eliminar-permisos', 'group_key' => 'Seguridad']);

        $permisos = Permission::all();
        foreach ($permisos as $key => $permiso) {
            $superadmin->givePermissionTo($permiso);
            $admin->givePermissionTo($permiso);
        }

        //permisos para editor
        $editor->givePermissionTo($p_listar_usuarios);

        //permisos para todos los roles
        $permisos_globales = [
            $p_dashboard_user,
            $p_read_auth,
            $p_ver_perfil_user,
            $p_editar_perfil_user
        ];
        foreach ($permisos_globales as $p) {
            $cliente->givePermissionTo($p);
            $autor->givePermissionTo($p);
            $editor->givePermissionTo($p);
            $suscriptor->givePermissionTo($p);
        }

        //USER 1 con rol de admin
        $user_superadmin = User::find(1);
        $user_superadmin->assignRole('admin');

        //USER 2 con rol de editor
        $user_editor = User::find(2);
        $user_editor->assignRole('editor');
    }
}