<?php

namespace Database\Seeders\ControlElectoral;

use App\Models\ControlElectoral\Acta;
use App\Models\ControlElectoral\CandidatoActa;
use App\Models\ControlElectoral\Junta;
use App\Models\ControlElectoral\Recinto;
use Illuminate\Database\Seeder;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Optix\Media\MediaUploader;

class ActaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Acta::factory(10)->create();

        DB::table('actas')->delete();
        DB::statement('ALTER TABLE actas AUTO_INCREMENT = 1');


        //Acta 1
        $junta_1 = Junta::find(1);
        $recinto_1 = $junta_1->recinto;
        $codigo_1 =  $recinto_1->codigo.'-'.$junta_1->codigo;

        $acta_1 = Acta::create([
            "codigo" => $codigo_1,
            "junta_id" => $junta_1->id,
            "votos_blancos" => 80,
            "votos_nulos" => 60,
            "votos_validos" => 230,
            "estado" => true,
            "ingresada_por" => 3,
            "visualizado" => true,

        ]);

        //Subir imagen
        $directory = public_path("images/control_electoral/actas/");
        $full_path = $directory."no-image.png";
        // echo $acta_1['codigo'].': '. $full_path."\n";
        $file = new UploadedFile($full_path,"no-image.png");
        $media = MediaUploader::fromFile($file)->upload();
        $acta_1->attachMedia($media,'acta');

        //Votos
        $votos_candidatos = [
            [1, $acta_1->id ,10, 2],
            [2, $acta_1->id, 20, 2],
            [3, $acta_1->id, 10, 2],
            [4, $acta_1->id, 40, 2],
            [5, $acta_1->id, 40, 2],
            [6, $acta_1->id, 20, 2],
            [7, $acta_1->id, 50, 2],
            [8, $acta_1->id, 20, 2],
            [9, $acta_1->id, 20, 2],
    
        ];

        foreach( $votos_candidatos as $votos_candidato){

            CandidatoActa::create([
                "candidato_id" => $votos_candidato[0],
                "acta_id" => $votos_candidato[1],
                "votos" => $votos_candidato[2],
                "procesada_por" => $votos_candidato[3],
              
            ]);

        }

    


        //Acta 2
        $junta_2= Junta::find(100);
        $recinto_2 = $junta_2->recinto;
        $codigo_2=  $recinto_2->codigo.'-'.$junta_2->codigo;


        $acta_2 = Acta::create([
            "codigo" => $codigo_2,
            "junta_id" => $junta_2->id,
            "votos_blancos" => 80,
            "votos_nulos" => 60,
            "votos_validos" => 230,
            "estado" => false,
            "ingresada_por" => 3,

        ]);

        //Subir imagen
        $directory = public_path("images/control_electoral/actas/");
        $full_path = $directory."no-image.png";
        // echo $acta_1['codigo'].': '. $full_path."\n";
        $file = new UploadedFile($full_path,"no-image.png");
        $media = MediaUploader::fromFile($file)->upload();
        $acta_2->attachMedia($media,'acta');



    }



}

