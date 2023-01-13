<?php

namespace Database\Seeders\ControlElectoral;

use App\Imports\ControlElectoral\CandidatosImport;
use App\Imports\ControlElectoral\RecintosImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CandidatoSeeder
 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('candidatos')->delete();
        DB::statement('ALTER TABLE candidatos AUTO_INCREMENT = 1');

        $archivo = "database/data/candidatos2023.xlsx";
        Excel::import(new CandidatosImport, $archivo);

    }



}

