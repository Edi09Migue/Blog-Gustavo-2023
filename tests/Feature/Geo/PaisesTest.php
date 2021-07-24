<?php

namespace Tests\Feature\Geo;

use App\Models\Geo\Pais;
use App\Models\User;
use Database\Seeders\Geo\PaisesSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaisesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_seeder()
    {
        $this->seed(PaisesSeeder::class);

        $total_paises = Pais::count();

        $this->assertDatabaseCount('paises',$total_paises);
    }

    public function test_factory(){
        $canton = Pais::factory()->create([]);
        $this->assertDatabaseCount('paises',1);
    }

    
    public function test_dropdown_options(){
        $admin = User::factory()->create([]);

        $this->seed(PaisesSeeder::class);
        $total_paises = Pais::count();

        $this->actingAs($admin,'api')
            ->get('/api/admin/paises/dropdownOptions')
            ->assertJsonCount($total_paises)
            ->assertStatus(200);
    }
    
    public function test_list(){
        $admin = User::factory()->create([]);

        $this->seed(PaisesSeeder::class);
        $total_paises = Pais::count();

        $this->actingAs($admin,'api')
            ->get("/api/admin/paises")
            ->assertJson([
                'users'     => [],
                'total'    => $total_paises
            ])
            ->assertStatus(200);
    }
    
    public function test_list_filtro_estado(){
        $admin = User::factory()->create([]);

        $this->seed(PaisesSeeder::class);
        $total_paises = Pais::count();

        $this->actingAs($admin,'api')
            ->get("/api/admin/paises?estado=1")
            ->assertJson([
                'users'     => [],
                'total'    => $total_paises
            ])
            ->assertStatus(200);
    }
}
