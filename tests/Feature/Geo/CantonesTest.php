<?php

namespace Tests\Feature\Geo;

use App\Models\Geo\Canton;
use App\Models\User;
use Database\Seeders\Geo\CantonesSeeder;
use Database\Seeders\Geo\ProvinciasSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CantonesTest extends TestCase
{    
    use DatabaseMigrations;

    public function test_seeder()
    {
        $this->seed(CantonesSeeder::class);

        $total_cantones = Canton::count();

        $this->assertDatabaseCount('cantones',$total_cantones);
    }

    public function test_factory(){
        $canton = Canton::factory()->create([]);
        $this->assertDatabaseCount('cantones',1);
    }

    public function test_dropdown_options(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        $total_cantones = Canton::count();

        $this->actingAs($admin,'api')
            ->get('/api/admin/cantones/dropdownOptions')
            ->assertJsonCount($total_cantones)
            ->assertStatus(200);
    }

    public function test_dropdown_options_filtrados_por_provincia(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        
        $gid1 = "ECU.23_1";//Tungurahua
        $total_cantones = 9;
        
        $this->actingAs($admin,'api')
            ->get("/api/admin/cantones/dropdownOptions?gid1={$gid1}")
            ->assertJsonCount($total_cantones)
            ->assertStatus(200);
    }

    public function test_list(){
        $admin = User::factory()->create([]);

        $this->seed(ProvinciasSeeder::class);
        $this->seed(CantonesSeeder::class);
        $total_cantones = Canton::count();

        $this->actingAs($admin,'api')
            ->get("/api/admin/cantones")
            ->assertJson([
                'users'     => [],
                'total'    => $total_cantones
            ])
            ->assertSee('Esmeraldas')
            ->assertStatus(200);
    }

    public function test_list_filtro_estado(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        $total_cantones = 9;

        $this->actingAs($admin,'api')
            ->get("/api/admin/cantones?estado=1")
            ->assertJson([
                'users'     => [],
                'total'    => $total_cantones
            ])
            ->assertStatus(200);
    }

    public function test_list_filtro_provincia(){
        $admin = User::factory()->create([]);

        $this->seed(ProvinciasSeeder::class);
        $this->seed(CantonesSeeder::class);
        $tungurahua_id = 23;
        $total_cantones = 9;

        $this->actingAs($admin,'api')
            ->get("/api/admin/cantones?provincia={$tungurahua_id}")
            ->assertJson([
                'users'     => [],
                'total'    => $total_cantones
            ])
            ->assertStatus(200);
    }

    public function test_show(){
        $admin = User::factory()->create([]);

        $canton = Canton::factory()->create([]);
        
        $this->actingAs($admin,'api')
            ->get("/api/admin/cantones/{$canton->id}")
            ->assertJson($canton->toArray())
            ->assertStatus(200);
    }

    public function test_editar(){
        $admin = User::factory()->create([]);

        $canton = Canton::factory()->create([]);
        $data = [
            'nombre'    => 'Updated'
        ];
        $this->actingAs($admin,'api')
            ->put("/api/admin/cantones/{$canton->id}",$data)
            ->assertJson([
                'msg'       => 'Cantón actualizado correctamente!',
                'status'    => TRUE
            ])
            ->assertStatus(200);
        
        $this->assertDatabaseHas('cantones',[
            'id'    => $canton->id,
            'nombre' => 'Updated'
        ]);
    }
}
