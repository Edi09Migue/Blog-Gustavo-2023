<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ImportarUsuariosTest extends TestCase
{
    use DatabaseMigrations;

    public function test_upload_excel()
    {
        $admin = User::factory()->create();

        $archivo = "UsuariosExcel.xlsx";
        
        $response = $this->actingAs($admin,'api')
                    ->post('/api/admin/usuarios/import',[

                    ]);
        $response->dump();
        $response->assertStatus(200);
    }
}
