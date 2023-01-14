<?php

namespace Database\Seeders\ControlElectoral;

use App\Models\ControlElectoral\Acta;
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

        $junta = Junta::find(1);
        $recinto = $junta->recinto;
        $codigo =  $recinto->codigo.'-'.$junta->codigo;

        $acta = Acta::create([
            "codigo" => $codigo,
            "junta_id" => $junta->id,
            "votos_blancos" => 80,
            "votos_nulos" => 60,
            "votos_validos" => 230,
            "procesado_por" => 3,

        ]);

        //Subir imagen
        $directory = public_path("images/control_electoral/actas/");
        $full_path = $directory."no-image.png";
        //dd($full_path);
        echo $acta['codigo'].': '. $full_path."\n";
        $file = new UploadedFile($full_path,"no-image.png");
        $media = MediaUploader::fromFile($file)->upload();
        $acta->attachMedia($media,'acta');




    }



}

