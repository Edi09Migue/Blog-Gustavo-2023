<?php

namespace Tests\Feature\Geo;

use App\Models\Geo\Provincia;
use App\Models\User;
use Database\Seeders\Geo\PaisesSeeder;
use Database\Seeders\Geo\ProvinciasSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProvinciasTest extends TestCase
{
    use DatabaseMigrations;

    public function test_seeder()
    {
        $this->seed(ProvinciasSeeder::class);

        $total_provincias = Provincia::count();

        $this->assertDatabaseCount('provincias',$total_provincias);
    }

    public function test_factory(){
        $provincia = Provincia::factory()->create([]);
        $this->assertDatabaseCount('provincias',1);
    }
    
    public function test_dropdown_options(){
        $admin = User::factory()->create([]);

        $this->seed(ProvinciasSeeder::class);
        $total_provincias = Provincia::count();

        $this->actingAs($admin,'api')
            ->get('/api/admin/provincias/dropdownOptions')
            ->assertJsonCount($total_provincias)
            ->assertStatus(200);
    }

    public function test_list(){
        $admin = User::factory()->create([]);

        $this->seed(PaisesSeeder::class);
        $this->seed(ProvinciasSeeder::class);
        $total_provincias = Provincia::count();

        $this->actingAs($admin,'api')
            ->get("/api/admin/provincias")
            ->assertJson([
                'users'     => [],
                'total'    => $total_provincias
            ])
            ->assertSee('Azuay')
            ->assertSee('Ecuador')
            ->assertStatus(200);
    }
    
    public function test_list_filtro_estado(){
        $admin = User::factory()->create([]);

        $this->seed(ProvinciasSeeder::class);
        $total_provincias = 24;//Total Ecuador

        $this->actingAs($admin,'api')
            ->get("/api/admin/provincias?estado=1")
            ->assertJson([
                'users'     => [],
                'total'    => $total_provincias
            ])
            ->assertStatus(200);
    }

}
