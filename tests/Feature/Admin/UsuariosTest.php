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

        $user_info = UserInfo::factory()->raw();

        $this->actingAs($admin,'api')
        ->put("/api/admin/usuarios/{$data->id}",[
            'email'     => 'updated@test.com',
            'user_info' => $user_info
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
}
