<?php

namespace Database\Seeders;

use App\Models\Parroquia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ParroquiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "database/backups/parroquias.json";

        $content = File::get($filename);

        $parroquias_gadm = json_decode($content);
        
        
        foreach($parroquias_gadm as $parroquia){
            
            $p = new Parroquia();
            $p->gid0 = $parroquia->gid0;//pais
            $p->gid1 = $parroquia->gid1;//provincia
            $p->gid2 = $parroquia->gid2;//canton
            $p->gid3 = $parroquia->gid3;//parroquia
            //$p->icono = $parroquia->icono;
            $p->nombre = $parroquia->nombre;
            $p->descripcion = $parroquia->descripcion;
            $p->nombre_corto = $parroquia->nombre;
            //$p->slug = $parroquia->slug;
            $p->tipo = $parroquia->tipo;
            $p->engtype = $parroquia->engtype;
           // dd($parroquia);
            //$p->bandera_url = strtolower(substr($parroquia->code, 0,2)).'.svg' ;
            $p->minx = $parroquia->minx;
            $p->miny = $parroquia->miny;
            $p->maxx = $parroquia->maxx;
            $p->maxy = $parroquia->maxy;
            $p->lat = $parroquia->lat;
            $p->lng = $parroquia->lng;
            //true solo para tungurahua
            $p->estado = $parroquia->gid1=="ECU.23_1" ? true: false;
            $p->zoom = 13;
            $p->save();
        }
    }
}
