<?php

namespace Database\Seeders;

use Database\Seeders\ControlElectoral\RecintoSeeder;
use Illuminate\Database\Seeder;

class ControlElectoralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RecintoSeeder::class,
            
        ]);
    }
}