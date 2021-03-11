<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            PermisosSeeder::class,
            ConfiguracionesSeeder::class,

            FakeUsersSeeder::class,

            PaisesSeeder::class,
            ProvinciasSeeder::class,
            CantonesSeeder::class,
            ParroquiasSeeder::class,
        ]);
    }
}
