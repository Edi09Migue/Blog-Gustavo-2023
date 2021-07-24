<?php

namespace Tests\Feature\Geo;

use App\Models\Geo\Canton;
use App\Models\Geo\Parroquia;
use App\Models\Geo\Provincia;
use App\Models\User;
use Database\Seeders\Geo\CantonesSeeder;
use Database\Seeders\Geo\ParroquiasSeeder;
use Database\Seeders\Geo\ProvinciasSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParroquiasTest extends TestCase
{
    use DatabaseMigrations;

    public function test_seeder()
    {
        $this->seed(ParroquiasSeeder::class);

        $total_parroquias = Parroquia::count();

        $this->assertDatabaseCount('parroquias',$total_parroquias);
    }
    
    public function test_factory(){
        $parroquia = Parroquia::factory()->create([]);
        $this->assertDatabaseCount('parroquias',1);
    }

    public function test_dropdown_options(){
        $admin = User::factory()->create([]);

        $this->seed(ParroquiasSeeder::class);
        $total_parroquias = Parroquia::count();

        $this->actingAs($admin,'api')
            ->get('/api/admin/parroquias/dropdownOptions')
            ->assertJsonCount($total_parroquias)
            ->assertStatus(200);
    }

    public function test_dropdown_options_filtrados_por_canton(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        $this->seed(ParroquiasSeeder::class);
        
        $gid1 = "ECU.23_1";//Tungurahua
        $gid2 = "ECU.23.1_1";//Ambato
        $total_parroquias = 19;
        
        $this->actingAs($admin,'api')
            ->get("/api/admin/parroquias/dropdownOptions?gid2={$gid2}")
            ->assertJsonCount($total_parroquias)
            ->assertStatus(200);
    }
    
    public function test_list(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        $this->seed(ParroquiasSeeder::class);
        $total_parroquias = Parroquia::count();

        $this->actingAs($admin,'api')
            ->get("/api/admin/parroquias")
            ->assertJson([
                'users'     => [],
                'total'    => $total_parroquias
            ])
            ->assertStatus(200);
    }
    
    public function test_list_filtro_estado(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        $this->seed(ParroquiasSeeder::class);
        
        $total_parroquias = 53;//parroquias de tungurahua

        $this->actingAs($admin,'api')
            ->get("/api/admin/parroquias?estado=1")
            ->assertJson([
                'users'     => [],
                'total'    => $total_parroquias
            ])
            ->assertStatus(200);
    }

    public function test_list_filtro_provincia(){
        $admin = User::factory()->create([]);

        $this->seed(ProvinciasSeeder::class);
        $this->seed(CantonesSeeder::class);
        $this->seed(ParroquiasSeeder::class);
        
        $gid1 = "ECU.23_1";//Tungurahua
        $provincia_tungurahua = Provincia::where('gid1',$gid1)->first();
        $total_parroquias = 53;//parroquias de tungurahua

        $this->actingAs($admin,'api')
            ->get("/api/admin/parroquias?provincia={$provincia_tungurahua->id}")
            ->assertJson([
                'users'     => [],
                'total'    => $total_parroquias
            ])
            ->assertStatus(200);
    }

    public function test_list_filtro_canton(){
        $admin = User::factory()->create([]);

        $this->seed(CantonesSeeder::class);
        $this->seed(ParroquiasSeeder::class);
                
        $gid2 = "ECU.23.1_1";//Ambato
        $canton_ambato = Canton::where('gid2',$gid2)->first();
        $total_parroquias = 19;//parroquias de ambato

        $this->actingAs($admin,'api')
            ->get("/api/admin/parroquias?canton={$canton_ambato->id}")
            ->assertJson([
                'users'     => [],
                'total'    => $total_parroquias
            ])
            ->assertStatus(200);
    }
    
    public function test_show(){
        $admin = User::factory()->create([]);

        $parroquia = Parroquia::factory()->create([]);
        
        $this->actingAs($admin,'api')
            ->get("/api/admin/parroquias/{$parroquia->id}")
            ->assertJson($parroquia->toArray())
            ->assertStatus(200);
    }
    
    public function test_editar(){
        $admin = User::factory()->create([]);

        $parroquia = Parroquia::factory()->create([]);
        $data = [
            'nombre'    => 'Updated'
        ];
        $this->actingAs($admin,'api')
            ->put("/api/admin/parroquias/{$parroquia->id}",$data)
            ->assertJson([
                'msg'       => 'Parroquia actualizada correctamente!',
                'status'    => TRUE
            ])
            ->assertStatus(200);
        
        $this->assertDatabaseHas('parroquias',[
            'id'    => $parroquia->id,
            'nombre' => 'Updated'
        ]);
    }

}
