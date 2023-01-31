<?php

namespace Database\Seeders;

use Database\Seeders\ControlElectoral\CandidatoActaSeeder;
use Database\Seeders\ControlElectoral\CandidatoSeeder;
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
            CandidatoSeeder::class,
            // ActaSeeder::class,
            // CandidatoActaSeeder::class,
            
        ]);
    }
}