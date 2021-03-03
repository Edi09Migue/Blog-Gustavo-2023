<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Toma la imagen en formato BASE64 y la almacena en un archivo
     * en la carpeta images/$folder/ con la siguiente sintaxis
     * [filename].[formato] 
     */
    public function uploadAvatar($imagenbase64, $folder = '/images/', $fullpath=false){
        $path = public_path().$folder;

        //separo la cadena data por la coma
        $data = explode(',', $imagenbase64);
        //si no viene una imagen en base 64 retorno null
        if(count($data)<2) return null;
        //obtengo el formato de la imagen
        $formato = $data[0];
        if(str_contains($formato,'image/png')){
            $formato='.png';
        }elseif(str_contains($formato,'image/jpeg')){
            $formato='.jpg';
        }elseif(str_contains($formato,'jpg')){
            $formato='.jpg';
        }elseif(str_contains($formato,'svg')){
            $formato='.svg';
        }
        //genero nombre unico para la imagen agregando la fecha
        $filename = date('mdYHis') . uniqid();
        $name = $filename.$formato;
        
        //creo un archivo temporal vacio con el nuevo nombre en la carpeta que iene permisos de escritura
        $ifp = fopen($path.$name, "wb"); 
        //escribo en el nuevo archivo el contenido despues de la coma
        fwrite($ifp, base64_decode($data[1])); //docodificando el base64
        //cierro el archivo
        fclose($ifp);
        return $fullpath ? $path.$name : $name;
    }
    
    public function eliminarFile($file_path){
        //Elimino archivo si existe
        if(File::exists($file_path))
            File::delete($file_path);
    }
}
