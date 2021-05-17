<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UsuariosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        //$this->seed();
        // Run a specific seeder...
        //$this->seed(OrderStatusSeeder::class);

        $admin =  User::factory()->create();

        $data = User::factory()->raw();

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios',$data)
            //->dump()
            ->assertJson(['status'=>true])
            ->assertStatus(200);

        $this->assertDatabaseHas('users',[
            'email' => $data['email']
        ]);
    }

    public function test_update_user(){
        $admin =  User::factory()->create();

        $data = User::factory()->create();

        $this->actingAs($admin,'api')
        ->put("/api/admin/usuarios/{$data->id}",[
            'email' => 'updated@test.com'
        ])
        //->dump()
        ->assertJson(['status'=>true])
        ->assertStatus(200);

        $this->assertDatabaseHas('users',[
            'email' => 'updated@test.com'
        ]);
    }

    public function test_delete_user(){
        $admin =  User::factory()->create();

        $this->actingAs($admin,'api')
            ->delete("/api/admin/usuarios/{$admin->id}")
            ->assertJson(['status'=>true])
            ->assertStatus(200);
            
    }

    public function test_unique_user_email(){

        $admin =  User::factory()->create();

        $data = User::factory()->raw([
            'email' => $admin->email
        ]);

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios',$data)
            //->dump()
            ->assertJson(['status'=>false])
            ->assertStatus(200);

        
    }

    public function test_unique_username(){

        $admin =  User::factory()->create();

        $data = User::factory()->raw([
            'username' => $admin->username
        ]);

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios',$data)
            //->dump()
            ->assertJson(['status'=>false])
            ->assertStatus(200);

        
    }
}
