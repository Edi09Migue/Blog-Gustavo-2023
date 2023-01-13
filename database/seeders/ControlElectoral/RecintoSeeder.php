<?php

namespace Database\Seeders\ControlElectoral;

use App\Imports\ControlElectoral\RecintosImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RecintoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('juntas')->delete();
        DB::table('recintos')->delete();
        DB::statement('ALTER TABLE juntas AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE recintos AUTO_INCREMENT = 1');

        $archivo = "database/data/recintos2023.xlsx";
        Excel::import(new RecintosImport, $archivo);

    }



}

