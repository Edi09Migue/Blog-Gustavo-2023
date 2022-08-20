<?php

namespace Database\Seeders;

use App\Models\Inscrito;
use Illuminate\Database\Seeder;

class InscritoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inscritos = Inscrito::factory(100)->create();
    }
}
