<?php

namespace Tests\Feature\Admin;

use App\Models\Configuracion;
use App\Models\User;
use Database\Seeders\ConfiguracionesSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfiguracionesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list()
    {
        $this->seed(ConfiguracionesSeeder::class);

        $admin = User::factory()->create();

        $configuracions = Configuracion::all();

        $this->actingAs($admin, 'api')
            ->get('/api/admin/configs')
            //->dump()
            ->assertJson([
                'items' => [],
                'total' => $configuracions->count()
            ])
            ->assertStatus(200);
    }

    public function test_main_settings()
    {
        $this->seed(ConfiguracionesSeeder::class);
        $admin = User::factory()->create();

        $this->actingAs($admin, 'api')
            ->get('/api/settings')
            //->dump()
            ->assertJson([])
            ->assertStatus(200);
    }

    public function test_crear()
    {
        $admin = User::factory()->create();

        $data = Configuracion::factory()->raw();

        $this->actingAs($admin, 'api')
            ->post('/api/admin/configs', $data)
            //->dump()
            ->assertJson([
                'status' => true,
                'msg'   => "{$data['key']} creado!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('configuraciones', 1);
    }

    public function test_crear_campos_required()
    {
        $admin = User::factory()->create();

        $data = Configuracion::factory()->raw([
            'key' => '',
            'value' => ''
        ]);

        $this->actingAs($admin, 'api')
            ->post('/api/admin/configs', $data)
            //->dump()
            //verifico que el array datatiene 2 errores
            ->assertJsonCount(2, 'data')
            ->assertJson([
                'status' => false,
                'msg'   => "El campo key es obligatorio."
            ])
            ->assertStatus(200);

        $this->assertDatabaseCount('configuraciones', 0);
    }

    public function test_editar_mail_settings()
    {
        $this->seed(ConfiguracionesSeeder::class);
        $admin = User::factory()->create();

        $email_settings = [
            'servidor_smtp'     => '567',
            'user_smtp'         => 'test',
            'password_smtp'     => '12345',
            'puerto_smtp'       => 23,
            'encryption_smtp'   => 'tls',
        ];

        $this->actingAs($admin, 'api')
            ->put("/api/admin/configs/correo", $email_settings)
            //->dump()
            ->assertJson([
                'status' => true,
                'data'   => "5 configuraciones",
                'msg'   => "Configuraciones actualizadas!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('configuraciones', [
            'group_key'=>'correo'
        ]);
    }

    public function test_editar_general_settings()
    {
        $this->seed(ConfiguracionesSeeder::class);
        $admin = User::factory()->create();

        $general_settings = [
            'company_name'      => 'SANTANA estudio', 
            'company_shortname' => 'SANTANA',
            'slogan'            => 'Ideas Originales y Creativas',
        ];

        $this->actingAs($admin, 'api')
            ->put("/api/admin/configs/general", $general_settings)
            //->dump()
            ->assertJson([
                'status' => true,
                'data'   => "3 configuraciones",
                'msg'   => "Configuraciones actualizadas!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('configuraciones', [
            'group_key'=>'correo'
        ]);
    }

    public function test_editar_sistema_settings()
    {
        $this->seed(ConfiguracionesSeeder::class);
        $admin = User::factory()->create();

        $sistema_settings = [
            'formato_fecha' => 'Y-m-d', 
            'iva'           => 12, 
            'decimales'     => 2,
            'idioma'        => 'es',    
            'en_mantenimiento'  => false,
        ];

        $this->actingAs($admin, 'api')
            ->put("/api/admin/configs/sistema", $sistema_settings)
            //->dump()
            ->assertJson([
                'status' => true,
                'data'   => "5 configuraciones",
                'msg'   => "Configuraciones actualizadas!"
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('configuraciones', [
            'group_key'=>'correo'
        ]);
    }

    // public function test_editar_campos_required()
    // {
    //     $admin = User::factory()->create();

    //     $data = [
    //         'name'          => 'tomar-bielas',
    //         'guard_name'    => 'web',
    //         'group_key'     => 'ofi'
    //     ];
    //     $configuracion = Configuracion::create($data);
    //     $configuracion->name = "";

    //     $this->actingAs($admin, 'api')
    //         ->put("/api/admin/configs/{$configuracion->id}", $configuracion->toArray())
    //         //->dump()
    //         //verifico que el array data tiene 1 error
    //         ->assertJsonCount(1, 'data')
    //         ->assertJson([
    //             'status' => false,
    //             'msg'   => "El campo nombre es obligatorio."
    //         ])
    //         ->assertStatus(200);

    //     $this->assertDatabaseHas('configuraciones', [
    //         'name'  => $data['name']
    //     ]);
    // }

    public function test_eliminar()
    {
        $admin = User::factory()->create();

        $configuracion = Configuracion::factory()->create();

        $this->actingAs($admin, 'api')
            ->delete("/api/admin/configs/{$configuracion->id}")
            //->dump()   
            ->assertJson([
                'status'    => true,
                'msg'       => "{$configuracion->key} eliminado!"
            ])
            ->assertStatus(200);
    }

    public function test_is_unique_field()
    {
        $admin = User::factory()->create();

        $configuracion = Configuracion::factory()->create();

        $nuevo_valor = "test";

        $this->actingAs($admin, 'api')
            ->post("/api/admin/configs/validate/key", [
                'value' => $nuevo_valor
            ])
            //->dump()   
            ->assertJson([
                'status'    => true,
                'valid'     => true,
                'msg'       => "{$nuevo_valor} esta disponible"
            ])
            ->assertStatus(200);
    }

    public function test_is_unique_field_falso()
    {
        $admin = User::factory()->create();

        $configuracion = Configuracion::factory()->create();


        $this->actingAs($admin, 'api')
            ->post("/api/admin/configs/validate/key", [
                'value' => $configuracion->key
            ])
            //->dump()   
            ->assertJson([
                'status'    => true,
                'valid'     => false,
                'msg'       => "{$configuracion->key} ya esta siendo utilizado por otra Configuración"
            ])
            ->assertStatus(200);
    }
}