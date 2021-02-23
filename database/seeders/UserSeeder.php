<?php

namespace Database\Seeders;

use App\Models\User;
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

        $user = new User();
        $user->name = "Nataly Armas";
        $user->email = "natalyarmasta@gmail.com";
        $user->username = "naty";
        $user->password = bcrypt('123456');
        $user->save();
        
    }
}
