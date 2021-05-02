<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use App\Notifications\WelcomeNotification;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FakeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $user->notify(new WelcomeNotification($user));
        die();
        $usuarios = User::factory()
        ->times(1)
        ->has(UserInfo::factory()->count(1))
        //->hasAttached(Role::first())
        ->create([]);
        
        $faker = Factory::create();
        $roles = Role::all();
        foreach($usuarios as $user){
            $user->assignRole($faker->randomElement($roles));
        }
        
        
    }
}
