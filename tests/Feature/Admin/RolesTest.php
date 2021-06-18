<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\PermisosSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list()
    {
        $this->seed(UserSeeder::class);
        $this->seed(PermisosSeeder::class);
        $admin = User::factory()->create();

        $roles = Role::all();

        $this->actingAs($admin, 'api')
            ->get('/api/admin/roles')
            //->dump()
            ->assertJson([
                'items' => [],
                'total' => $roles->count()
            ])
            ->assertStatus(200);
    }

    public function test_dropdown_options()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin, 'api')
            ->get('/api/admin/roles/dropdownOptions')
            //->dump()
            ->assertJson([])
            ->assertStatus(200);
    }

    public function test_crear_rol()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'rol-test',
            'guard_name'    => 'web',
            'description'   => 'Descripcion rol'
        ];

        $this->actingAs($admin, 'api')
            ->post('/api/admin/roles', $data)
            //->dump()
            ->assertJson([
                'status' => true,
                'msg'   => "{$data['name']} creado correctamente!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('roles', 1);
    }

    public function test_crear_campos_rol_required()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => '',
            'guard_name'    => '',
        ];

        $this->actingAs($admin, 'api')
            ->post('/api/admin/roles', $data)
            //->dump()
            //verifico que el array datatiene 2 errores
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'status' => false,
                'msg'   => "El campo nombre es obligatorio."
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('roles', 0);
    }

    public function test_editar_rol()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tester-role',
            'guard_name'    => 'web',
            'description'     => 'rol description'
        ];
        $role = Role::create($data);
        $role->name = "updated";

        $this->actingAs($admin, 'api')
            ->put("/api/admin/roles/{$role->id}", $role->toArray())
            //->dump()
            ->assertJson([
                'status' => true,
                'msg'   => "{$role->name} actualizado correctamente!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('roles', 1);
    }

    public function test_editar_campos_rol_required()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $role = Role::create($data);
        $role->name = "";

        $this->actingAs($admin, 'api')
            ->put("/api/admin/roles/{$role->id}", $role->toArray())
            //->dump()
            //verifico que el array data tiene 1 error
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'status' => false,
                'msg'   => "El campo nombre es obligatorio."
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('roles', [
            'name'  => $data['name']
        ]);
    }

    public function test_eliminar_rol()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $role = Role::create($data);


        $this->actingAs($admin, 'api')
            ->delete("/api/admin/roles/{$role->id}")
            //->dump()   
            ->assertJson([
                'status'    => true,
                'msg'       => "{$data['name']} eliminado correctamente!"
            ])
            ->assertStatus(200);
    }

    public function test_eliminar_rol_asignado()
    {
        $this->seed(UserSeeder::class);

        $this->seed(PermisosSeeder::class);

        $role = Role::find(1);
        $admin = User::factory()->create();

        $this->actingAs($admin, 'api')
            ->delete("/api/admin/roles/{$role->id}")
            //->dump()   
            ->assertJson([
                'status'    => true,
                'msg'       => "{$role->name} eliminado correctamente!"
            ])
            ->assertStatus(200);
    }

    public function test_is_unique_field()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $role = Role::create($data);

        $nombre_test = "tomar-ron";

        $this->actingAs($admin, 'api')
            ->post("/api/admin/roles/validate/name", [
                'value' => $nombre_test
            ])
            //->dump()   
            ->assertJson([
                'status'    => true,
                'valid'     => true,
                'msg'       => "{$nombre_test} esta disponible"
            ])
            ->assertStatus(200);
    }

    public function test_is_unique_field_falso()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $role = Role::create($data);

        $nombre_test = "tomar-bielas";

        $this->actingAs($admin, 'api')
            ->post("/api/admin/roles/validate/name", [
                'value' => $nombre_test
            ])
            //->dump()   
            ->assertJson([
                'status'    => true,
                'valid'     => false,
                'msg'       => "{$nombre_test} ya esta siendo utilizado por otro rol"
            ])
            ->assertStatus(200);
    }
}