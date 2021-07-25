<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\UserInfo;
use Database\Seeders\PermisosSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsuariosTest extends TestCase
{
    use DatabaseMigrations;

    public function test_list()
    {
        $this->seed(UserSeeder::class);
     
        $admin = User::factory()->create();
        $users = User::all();
     
        $this->actingAs($admin, 'api')
            ->get('/api/admin/usuarios')
            //->dump()
            ->assertJson([
                'items' => [],
                'total' => $users->count()
            ])
            ->assertStatus(200);
    }

    public function test_list_solo_inactivos()
    {
        $this->seed(UserSeeder::class);
     
        $admin = User::factory()->create();
        
        $user_inactivo = User::factory()->create([
            'estado'    => User::STATUS_INACTIVO
        ]);
     
        $this->actingAs($admin, 'api')
            ->get('/api/admin/usuarios?estado='.User::STATUS_INACTIVO)
            //->dump()
            ->assertJson([
                'items' => [
                    $user_inactivo->toArray()
                ],
                'total' => 1
            ])
            ->assertStatus(200);
    }

    public function test_list_solo_administradores()
    {
        $this->seed(UserSeeder::class);
        $this->seed(PermisosSeeder::class);
     
        $admin = User::factory()->create();
        
        $role_id = 2;//rol admin
        
        
        $this->actingAs($admin, 'api')
            ->get('/api/admin/usuarios?role='.$role_id)
            //->dump()
            ->assertJson([
                'items' => [],
                'total' => 1
            ])
            ->assertStatus(200);
    }

    public function test_create_user()
    {
        $admin =  User::factory()->create();
        
        $data = [
            'name'          => 'tester-role',
            'guard_name'    => 'web',
            'description'     => 'rol description',
        ];
        $role = Role::create($data);

        $data = User::factory()->raw();
        $data['avatar'] = "data:image/png;base64,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";
        $user_info = UserInfo::factory()->raw();
        $data= array_merge($user_info,$data);
        
        $data['role'] = $role->id;

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios',$data)
            //->dump()
            ->assertJson(['status'=>true])
            ->assertStatus(200);

        $this->assertDatabaseHas('users',[
            'email' => $data['email']
        ]);

        $this->assertDatabaseHas('user_info',[
            'telefono' => $user_info['telefono']
        ]);
    }

    public function test_create_user_con_rol_inexistente()
    {
        $admin =  User::factory()->create();
        
        $data = User::factory()->raw();
        $user_info = UserInfo::factory()->raw();
        $data= array_merge($user_info,$data);
        
        $data['role'] = 1;

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios',$data)
            //->dump()
            ->assertJson([
                'status'=>false,
                'data'  => 'There is no role with id `1`.',
                'msg' => 'Error al crear usuario!'
            ])
            ->assertStatus(200);
        
    }

    public function test_create_user_validations()
    {

        $admin =  User::factory()->create();

        $data = User::factory()->raw([
            'username'=>'',
            'name'=>''
        ]);
        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios',$data)
            //->dump()
            ->assertJsonCount(2,'data')
            ->assertJson(['status'=>false])
            ->assertStatus(200);

    }

    public function test_show(){
        $admin =  User::factory()->create();

        $this->actingAs($admin,'api')
            ->get("/api/admin/usuarios/{$admin->id}")
            //->dump()
            //->assertJson(['status'=>true])
            ->assertStatus(200);

    }

    public function test_update_user(){
        $admin =  User::factory()->create();

        $data = User::factory()->create();
        
        $data->avatar = "data:image/png;base64,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";

        $role = Role::create([
            'name'          => 'tester-role',
            'guard_name'    => 'web',
            'description'     => 'rol description',
        ]);
        
        $user_info = UserInfo::factory()->raw();
        
        $this->actingAs($admin,'api')
        ->put("/api/admin/usuarios/{$data->id}",[
            'email'     => 'updated@test.com',
            'user_info' => $user_info,
            'password'  => '123456',
            'role'  => $role->id
        ])
        //->dump()
        ->assertJson(['status'=>true])
        ->assertStatus(200);

        $this->assertDatabaseHas('users',[
            'email' => 'updated@test.com'
        ]);
    }

    public function test_update_user_password(){
        $admin =  User::factory()->create();

        $data = User::factory()->create();

        $this->actingAs($admin,'api')
        ->put("/api/admin/usuario/{$data->id}/updatePassword",[
            'password'  => '123456',
            'password_confirmation'  => '123456'
        ])
        //->dump()
        ->assertJson([
            'msg'   => "{$data->username} actualizado!",
            'status'=>true
        ])
        ->assertStatus(200);
    }

    public function test_update_user_password_validations(){
        $admin =  User::factory()->create();

        $data = User::factory()->create();

        $this->actingAs($admin,'api')
        ->put("/api/admin/usuario/{$data->id}/updatePassword",[
            'password'  => '',
            'password_confirmation'  => '12345'
        ])
        ->dump()
        ->assertJson([
            'msg'   => "El campo contraseña es obligatorio.",
            'status'=>false
        ])
        ->assertStatus(200);
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

        $nombre_test = "email@test.com";

        $this->actingAs($admin,'api')
                ->post("/api/admin/usuarios/validate/email", [
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

    public function test_unique_user_email_falso(){

        $admin =  User::factory()->create();

        $this->actingAs($admin,'api')
                ->post("/api/admin/usuarios/validate/email", [
                    'value' => $admin->email
                ])
                //->dump()   
                ->assertJson([
                    'status'    => true,
                    'valid'     => false,
                    'msg'       => "{$admin->email} ya esta siendo utilizado por otro usuario"
                ])
                ->assertStatus(200);
    }

    public function test_unique_username(){

        $admin =  User::factory()->create();

        $username = "tester12";
        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios/validate/username',[
                'value' => $username
            ])
            //->dump()
            ->assertJson([
                'status'    => true,
                'valid'     => true,
                'msg'       => "{$username} esta disponible"
            ])
            ->assertStatus(200);        
    }

    public function test_unique_username_falso(){

        $admin =  User::factory()->create();

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios/validate/username',[
                'value' => $admin->username
            ])
            //->dump()
            ->assertJson([
                'status'    => true,
                'valid'     => false,
                'msg'       => "{$admin->username} ya esta siendo utilizado por otro usuario"
            ])
            ->assertStatus(200);        
    }

    public function test_reporte_preview(){
        $admin =  User::factory()->create();

        $this->actingAs($admin,'api')
            ->post('/api/admin/usuarios/reportes',[
                'tipo'      => 'full',
                'formato'   => 'preview'
            ])
            //->dump()
            ->assertSee('Reporte de Usuarios')
            ->assertStatus(200);        
    }
}
