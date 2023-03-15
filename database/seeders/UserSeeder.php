<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use App\Notifications\WelcomeNotification;
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

        //User 1
        $user = new User();
        $user->name = "Edisson Ibarra";
        $user->email = "edi09migue@gmail.com";
        $user->username = "edisson";
        $user->password = bcrypt('123456');
        $user->save();

        $user->notify(new WelcomeNotification($user));


        $info = new UserInfo([
            'id' => $user->id,
            'empresa' => 'EDISSON',
            'telefono' => '0984773251',
            'website' => 'https://edi.ec',
            'genero' => 'male',
            'birthdate' => '1994-08-13',
            'bio' => 'Me encanta la música',
            'idioma' => 'spanish',
            'pais' => 'Ecuador',
            'provincia' => 'Tungurahua',
            'ciudad' => 'Ambato',
            'postalcode' => '180150',
            'direccion_principal' => 'Camino el rey',
            'direccion_secundaria' => 'Floreana',
        ]);
        $info->save();

        //User 2 
        $user = new User();
        $user->name = "Gustavo Ibarra";
        $user->email = "gustavo@gmail.com";
        $user->username = "gustavo";
        $user->password = bcrypt('123456');
        $user->save();

        $user->notify(new WelcomeNotification($user));
  
  
        $info = new UserInfo([
            'id' => $user->id,
            'empresa' => 'Gustavo',
            'telefono' => '0984665754',
            'website' => 'https://gustavoibarra.com',
            'genero' => 'male',
            'birthdate' => '1994-08-13',
            'bio' => 'Me encanta la comunicación política',
            'idioma' => 'spanish',
            'pais' => 'Ecuador',
            'provincia' => 'Tungurahua',
            'ciudad' => 'Ambato',
            'postalcode' => '180150',
            'direccion_principal' => 'Camino el rey',
            'direccion_secundaria' => 'Floreana',
        ]);
        $info->save();


    

        
    }
}
