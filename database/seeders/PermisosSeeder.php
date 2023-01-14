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
        $digitalizador = Role::create(['name' => 'digitalizador']);
        $imagenes = Role::create(['name' => 'imagenes']);

        //
        $p_manage_all = Permission::create(['name' => 'manage-all', 'group_key' => 'Generales']);
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

        //Actas
        $p_listar_actas = Permission::create(['name' => 'listar-actas', 'group_key' => 'Admin']);
        $p_editar_actas = Permission::create(['name' => 'editar-actas', 'group_key' => 'Admin']);
        $p_ver_actas = Permission::create(['name' => 'ver-actas', 'group_key' => 'Admin']);

        //Resultados
        $p_listar_resultados = Permission::create(['name' => 'listar-resultados', 'group_key' => 'Admin']);




        $permisos = Permission::all();
        foreach ($permisos as $key => $permiso) {
            $superadmin->givePermissionTo($permiso);
            // $admin->givePermissionTo($permiso);
        }

        $superadmin->givePermissionTo($p_manage_all);

        //permisos para todos los roles
        $permisos_globales = [
            $p_dashboard_user,
            $p_read_auth,
            $p_ver_perfil_user,
            $p_editar_perfil_user
        ];
        
        foreach ($permisos_globales as $p) {
            $admin->givePermissionTo($p);
            $imagenes->givePermissionTo($p);
            $digitalizador->givePermissionTo($p);
        }
        //Permisos para admin
        $permisos_admin = Permission::where('group_key','Admin')->get();
        foreach ($permisos_admin as $key => $permiso) {
            $admin->givePermissionTo('ver-dashboard_user');
            $admin->givePermissionTo($permiso);

      }


        //USER 1 con rol de superadmin
        $user_superadmin_1 = User::find(1);
        $user_superadmin_1->assignRole('superadmin');

        //USER 2 con rol de superadmin
        $user_superadmin_2  = User::find(2);
        $user_superadmin_2->assignRole('superadmin');

        //USER 3 con rol de imagenes
        $user_imagenes = User::find(3);
        $user_imagenes->assignRole('imagenes');

        //USER 4 con rol de admin
        $user_admin  = User::find(4);
        $user_admin->assignRole('admin');
    }
}