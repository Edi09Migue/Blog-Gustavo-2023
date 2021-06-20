<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserProfileCtrlTest extends TestCase
{
    use DatabaseMigrations;

    public function test_update()
    {
        $admin = User::factory()->create([]);
        $admin->user_info = UserInfo::factory()->raw();
        $response = $this->actingAs($admin,'api')
                    ->put('/api/admin/profile/update',[
                        'name'  => 'tester'
                    ]);
        
        $response->assertJson([
            'status'    => true,
            'msg'       => $admin->username.' actualizado!'
        ]);
        $response->assertStatus(200);
    }

    public function test_update_password()
    {
        $admin = User::factory()->create([]);

        $response = $this->actingAs($admin,'api')
                ->put('/api/admin/profile/updatePassword',[
                    'old_password'  => 'password',
                    'password'      => '12345678',
                    'password_confirmation' =>  '12345678'
                ]);
        
        $response->assertJson([
            'status'    => true,
            'msg'       => $admin->username.' actualizado!'
        ]);
        $response->assertStatus(200);
    }

    public function test_update_password_required_fields()
    {
        $admin = User::factory()->create([]);

        $response = $this->actingAs($admin,'api')
                ->put('/api/admin/profile/updatePassword',[
                    'old_password'  => '',
                    'password'      => '',
                    'password_confirmation' =>  '12345678'
                ]);
        
        $response->assertJson([
            'status'    => false,
            'msg'       =>'El campo Contraseña actual es obligatorio.'
        ]);
        //$response->dump();
        $response->assertJsonCount(3,'data');
        $response->assertStatus(200);
    }

    public function test_update_password_original_incorrecta()
    {
        $admin = User::factory()->create([]);

        $response = $this->actingAs($admin,'api')
                ->put('/api/admin/profile/updatePassword',[
                    'old_password'  => 'pass',
                    'password'      => '12345678',
                    'password_confirmation' =>  '12345678'
                ]);
        
        $response->assertJson([
            'status'    => false,
            'msg'       => 'Contraseña antigua incorrecta!'
        ]);
        $response->assertStatus(200);
    }
}
