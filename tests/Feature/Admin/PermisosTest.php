<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\PermisosSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermisosTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list()
    {
        $this->seed(UserSeeder::class);
        $this->seed(PermisosSeeder::class);
        $admin = User::factory()->create();

        $permisos = Permission::all();

        $this->actingAs($admin, 'api')
            ->get('/api/admin/permisos')
            //->dump()
            ->assertJson([
                'items' => [],
                'total' => $permisos->count()
            ])
            ->assertStatus(200);
    }

    public function test_dropdown_options()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin, 'api')
            ->get('/api/admin/permisos/dropdownOptions')
            //->dump()
            ->assertJson([])
            ->assertStatus(200);
    }

    public function test_crear()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];

        $this->actingAs($admin, 'api')
            ->post('/api/admin/permisos', $data)
            //->dump()
            ->assertJson([
                'status' => true,
                'msg'   => "{$data['name']} creado!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('permissions', 1);
    }

    public function test_crear_campos_required()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => '',
            'guard_name'    => '',
            'group_key'     => 'ofi'
        ];

        $this->actingAs($admin, 'api')
            ->post('/api/admin/permisos', $data)
            //->dump()
            //verifico que el array datatiene 2 errores
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'status' => false,
                'msg'   => "El campo nombre es obligatorio."
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('permissions', 0);
    }

    public function test_editar()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $permiso = Permission::create($data);
        $permiso->name = "updated";

        $this->actingAs($admin, 'api')
            ->put("/api/admin/permisos/{$permiso->id}", $permiso->toArray())
            //->dump()
            ->assertJson([
                'status' => true,
                'msg'   => "{$permiso->name} actualizado!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('permissions', 1);
    }

    public function test_editar_campos_required()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $permiso = Permission::create($data);
        $permiso->name = "";

        $this->actingAs($admin, 'api')
            ->put("/api/admin/permisos/{$permiso->id}", $permiso->toArray())
            //->dump()
            //verifico que el array data tiene 1 error
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'status' => false,
                'msg'   => "El campo nombre es obligatorio."
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('permissions', [
            'name'  => $data['name']
        ]);
    }

    public function test_eliminar()
    {
        $admin = User::factory()->create();

        $data = [
            'name'          => 'tomar-bielas',
            'guard_name'    => 'web',
            'group_key'     => 'ofi'
        ];
        $permiso = Permission::create($data);


        $this->actingAs($admin, 'api')
            ->delete("/api/admin/permisos/{$permiso->id}")
            //->dump()   
            ->assertJson([
                'status'    => true,
                'msg'       => "{$data['name']} eliminado!"
            ])
            ->assertStatus(200);
    }

    public function test_eliminar_permiso_asignado()
    {
        $this->seed(UserSeeder::class);
        $this->seed(PermisosSeeder::class);

        $admin = User::find(1);
        $permiso = Permission::find(1);

        $this->actingAs($admin, 'api')
            ->delete("/api/admin/permisos/{$permiso->id}")
            //->dump()   
            ->assertJson([
                'status'    => true,
                'msg'       => "{$permiso->name} eliminado!"
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
        $permiso = Permission::create($data);

        $nombre_test = "tomar-ron";

        $this->actingAs($admin, 'api')
            ->post("/api/admin/permisos/validate/name", [
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
        $permiso = Permission::create($data);

        $nombre_test = "tomar-bielas";

        $this->actingAs($admin, 'api')
            ->post("/api/admin/permisos/validate/name", [
                'value' => $nombre_test
            ])
            //->dump()   
            ->assertJson([
                'status'    => true,
                'valid'     => false,
                'msg'       => "{$nombre_test} ya esta siendo utilizado por otro permiso"
            ])
            ->assertStatus(200);
    }
}