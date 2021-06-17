<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register()
    {
        $new_user = [
            'username'  => 'tester',
            'name'      => 'Tester name',
            'email'     => 'tester@test.com',
            'password'  => '12345678',
            'c_password'  => '12345678',
        ];

        $response = $this->post('/api/auth/register',$new_user);
        //$response->dump();
        $response->assertStatus(201);
    }

    public function test_login(){
        
        $this->artisan('passport:install');

        $user = User::factory()->create();

        $this->post('/api/auth/login',[
            'email' => $user->email,
            'password'  => 'password'
        ])
        //->dump()
        ->assertJson(['status'=>TRUE])
        ->assertStatus(200);
    }

    public function test_get_logged_user_data(){
        $user = User::factory()->create();

        $this->actingAs($user,'api')
            ->get('/api/auth/user')
            ->assertJson(['name'=>$user->name])
            ->assertStatus(200);
    }

    // public function test_logout(){
    //     $this->artisan('passport:install');
    //     $user = User::factory()->create();
    //     $this->post('/api/auth/login',[
    //         'email' => $user->email,
    //         'password'  => 'password'
    //     ]);

        
    //     $this->actingAs($user,'api')
    //         ->get('/api/auth/logout')
    //         ->dump()
    //         //->assertJson(['message'=>$user->name])
    //         ->assertStatus(200);
    // }

    public function test_get_user_notifications(){
        $user = User::factory()->create();

        $this->actingAs($user,'api')
            ->get('/api/auth/notifications')
            ->assertJson([])
            ->assertStatus(200);
    }

    public function test_send_reset_password_email(){
        $user = User::factory()->create();

        $this->post('/api/reset-password',['email'=> $user->email])
            ->assertStatus(200);
    }

    public function test_reset_password_recovery(){
        $user = User::factory()->create();

        $token = Password::broker()->createToken($user);

        $this->post('/api/auth/reset-password-user',[
            'token'     => $token,
            'email'     => $user->email,
            'password'  => 'nuevopass',
            'password_confirmation'  => 'nuevopass'
            ])
            ->dump()
            ->assertStatus(200);
    }

    
}
