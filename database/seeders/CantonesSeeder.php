<?php

namespace Database\Seeders;

use App\Models\Canton;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CantonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "database/backups/cantones.json";

        $content = File::get($filename);

        $cantones_gadm = json_decode($content);


        foreach($cantones_gadm as $canton){
            $p = new Canton();
            $p->gid0 = $canton->gid0;//pais
            $p->gid1 = $canton->gid1;//provincia
            $p->gid2 = $canton->gid2;//canton
            $p->nombre = $canton->nombre;
            $p->tipo = $canton->tipo;
            $p->engtype = $canton->engtype;
            //$p->bandera_url = strtolower(substr($canton->code, 0,2)).'.svg' ;
            $p->minx = $canton->minx;
            $p->miny = $canton->miny;
            $p->maxx = $canton->maxx;
            $p->maxy = $canton->maxy;
            $p->lat = $canton->lat;
            $p->lng = $canton->lng;
            $p->zoom = 13;
            //true solo para tungurahua
            $p->estado = $canton->gid1=="ECU.23_1" ? true: false;
            $p->save();
        }
    }
}
