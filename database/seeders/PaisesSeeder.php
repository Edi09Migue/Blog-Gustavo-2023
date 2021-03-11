<?php

namespace Database\Seeders;

use App\Models\Pais;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "database/backups/paises.json";

        $content = File::get($filename);

        $paises_gadm = json_decode($content, true);


        foreach($paises_gadm as $pais){
            //dd($pais);
            $p = new Pais($pais);
            $p->codigo = $p->code;
            $p->gid0 = $p->code;
            $p->nombre = $p->name;
            $p->lat = $p->y;
            $p->lng = $p->x;
            unset($p->gid);
            unset($p->code);
            unset($p->name);
            unset($p->x);
            unset($p->y);
            $p->save();
        }
    }
}
