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
        $user->name = "Jaime Santana";
        $user->email = "sistemas@santana.ec";
        $user->username = "dexterx17";
        $user->password = bcrypt('123456');
        $user->save();

        $user->notify(new WelcomeNotification($user));

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


        //User 2 
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


        //User 3 
        $user = new User();
        $user->name = "Manuel Guangasi";
        $user->email = "guangasi@gmail.com";
        $user->username = "manuel";
        $user->password = bcrypt('123456');
        $user->save();

        $user->notify(new WelcomeNotification($user));


        $info = new UserInfo([
        'id' => $user->id,
        'empresa' => 'Manuel',
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
        


        //User 4 
        $user = new User();
        $user->name = "Ricardo Fiallos";
        $user->email = "ricardo@gmail.com";
        $user->username = "ricardo";
        $user->password = bcrypt('123456');
        $user->save();

        $user->notify(new WelcomeNotification($user));
  
  
        $info = new UserInfo([
            'id' => $user->id,
            'empresa' => 'Ricardo',
            'telefono' => '0981446945',
            'website' => 'https://ricardo.ec',
            'genero' => 'male',
            'birthdate' => '1994-08-13',
            'bio' => 'Me encanta la tecnología',
            'idioma' => 'spanish',
            'pais' => 'Ecuador',
            'provincia' => 'Tungurahua',
            'ciudad' => 'Ambato',
            'postalcode' => '180150',
            'direccion_principal' => 'Av. Carlos Rubia Infante',
            'direccion_secundaria' => 'Jose Rudecindo Ingavelez',
        ]);
        $info->save();


    

        
    }
}
