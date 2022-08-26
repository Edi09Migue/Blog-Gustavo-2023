<?php

namespace Database\Seeders\Geo;

use App\Models\Geo\Parroquia;
use Illuminate\Database\Seeder;

class ParroquiasUrbanasAmbatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parroquia = Parroquia::find(5);

        $parroquiasUrbanasAmbato = [
            'San Francisco',
            'Pishilata',
            'La Península',
            'La Merced',
            'La Matriz',
            'Huachi Loreto',
            'Huachi Chico',
            'Ficoa',
            'Celiano Monge',
            'Atocha',
        ];

        $last_code = "ECU.23.1.19_1";
        $last=19;
        foreach($parroquiasUrbanasAmbato as $par){
            $p = new Parroquia();
            $last++;
            $code = "ECU.23.1.{$last}_1";
            $p->gid0 = $parroquia->gid0; //pais
            $p->gid1 = $parroquia->gid1; //provincia
            $p->gid2 = $parroquia->gid2; //canton
            $p->gid3 = $code; //parroquia
            //$p->icono = $parroquia->icono;
            $p->nombre = $par;
            $p->descripcion = $par;
            $p->nombre_corto = $par;
            //$p->slug = $parroquia->slug;
            $p->tipo = 'Urbana';
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
            $p->estado = true;
            $p->zoom = 13;
            $p->save();
        }
    }
}
