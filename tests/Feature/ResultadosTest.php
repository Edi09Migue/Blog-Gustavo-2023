<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResultadosTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list()
    {
        $this->seed(DatabaseSeeder::class);
        
        $admin = User::factory()->create();

        
        $this->actingAs($admin, 'api')
            ->get('/api/control-electoral/resultados/totales-por-candidato')
            //->dump()
            ->assertJson([
                'status' => true,
                'items' => []
            ])
            ->assertStatus(200);
    }
}
