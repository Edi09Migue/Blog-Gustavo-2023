<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Jaime Santana";
        $user->email = "sistemas@santana.ec";
        $user->username = "dexterx17";
        $user->password = bcrypt('123456');
        $user->save();

        $info = new UserInfo([
            'id' => $user->id,
            'empresa' =>'SANTANA eCORP',
            'telefono' => '0983706086',
            'website' => 'https://jaime.santana.ec',
            'genero' => 'male',
            'birthdate' => '1990-02-08',
            'bio' => 'Me encanta la naturaleza',
            'idioma' => 'spanish',
            'pais' => 'Ecuador',
            'provincia' => 'Tungurahua',
            'ciudad' => 'Ambato',
            'postalcode' => '180150',
            'direccion_principal' => 'Pastaza 2-02 y Tres Carabelas',
            'direccion_secundaria' => 'Cdla. Oriente',
        ]);
        $info->save();

        $user = new User();
        $user->name = "Nataly Armas";
        $user->email = "natalyarmasta@gmail.com";
        $user->username = "naty";
        $user->password = bcrypt('123456');
        $user->save();

        $info = new UserInfo([
            'id' => $user->id,
            'empresa' =>'SANTANA eCORP',
            'telefono' => '0995629151',
            'website' => 'https://narmas.santana.ec',
            'genero' => 'female',
            'birthdate' => '1991-11-23',
            'bio' => 'Me encantan los animales',
            'idioma' => 'spanish',
            'pais' => 'Ecuador',
            'provincia' => 'Tungurahua',
            'ciudad' => 'Ambato',
            'postalcode' => '180150',
            'direccion_principal' => 'Pastaza 2-02 y Tres Carabelas',
            'direccion_secundaria' => 'Cdla. Oriente',
        ]);
        $info->save();
        
    }
}
