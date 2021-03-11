<?php

namespace Database\Seeders;

use App\Models\Provincia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "database/backups/provincias.json";

        $content = File::get($filename);

        $provincias_gadm = json_decode($content);


        foreach($provincias_gadm as $provincia){
            $p = new Provincia();
            $p->gid0 = $provincia->gid0;//pais
            $p->gid1 = $provincia->gid1;//provincia
            $p->nombre = $provincia->nombre;
            $p->tipo = $provincia->tipo;
            $p->engtype = $provincia->engtype;
            //$p->bandera_url = strtolower(substr($provincia->code, 0,2)).'.svg' ;
            $p->minx = $provincia->minx;
            $p->miny = $provincia->miny;
            $p->maxx = $provincia->maxx;
            $p->maxy = $provincia->maxy;
            $p->lat = $provincia->lat;
            $p->lng = $provincia->lng;
            $p->zoom = 13;
            $p->estado = true;
            $p->save();
        }
    }
}
