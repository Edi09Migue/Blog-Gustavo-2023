<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\UploadedFile;
use Optix\Media\MediaUploader;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Sube una image en base 64 y la relaciona con el model especificado 
     * utilizando las bondades de Optix/Media
     * 
     * @param String $imagenbase64  Imagen codificada en base64
     * @param String $folder  Path en la que se va a subir la imagen original
     * @param App\Model $mode  instancia del model con el que se va a relacionar esta imagen
     * @param String $collection  Nombre de la colección en la que se va agregar la imagen
     * @param String $field  Campo del model que contiene el nombre que se le dará a la imagen
     * @param Bool $cleanCollection TRUE para vaciar la colección de imagenes 
     */
    public function uploadAndConvert($imagenbase64, $folder = '/images/', Model $model, $collection = 'main', $field = 'nombre', $cleanCollection = false)
    {
        $public_path = public_path() . $folder;
        //Subo la imagen en base 64 y la guardo en la carpeta
        $path_imagen = $this->uploadAvatar($imagenbase64, $folder);
        //Convierto el archivo subido a un UploadedFile
        $origen = new UploadedFile($public_path . $path_imagen, $path_imagen);
        //Copio el archivo al storage local
        $imagenes = MediaUploader::fromFile($origen)->useName($model->{$field})->upload();

        //Si es una carga en la coleccion principal o pedimos vaciar la coleccion
        if ($collection == "main" || $cleanCollection) {
            //borro todas las imagenes de la coleccion especificada
            foreach ($model->getMedia($collection) as $media) {
                $media->delete();
            }
        }
        //Genero las conversiones para 'thumb'(64*64), 'preview'(370*370) y 'square'(500*500)
        $model->attachMedia($imagenes, $collection);
    }

    /**
     * Toma la imagen en formato BASE64 y la almacena en un archivo
     * en la carpeta images/$folder/ con la siguiente sintaxis
     * [filename].[formato] 
     */
    public function uploadAvatar($imagenbase64, $folder = '/images/', $fullpath = false)
    {
        $path = public_path() . $folder;

        //separo la cadena data por la coma
        $data = explode(',', $imagenbase64);
        //si no viene una imagen en base 64 retorno null
        if (count($data) < 2) return null;
        //obtengo el formato de la imagen
        $formato = $data[0];
        if (str_contains($formato, 'image/png')) {
            $formato = '.png';
        } elseif (str_contains($formato, 'image/jpeg')) {
            $formato = '.jpg';
        } elseif (str_contains($formato, 'jpg')) {
            $formato = '.jpg';
        } elseif (str_contains($formato, 'svg')) {
            $formato = '.svg';
        }
        //genero nombre unico para la imagen agregando la fecha
        $filename = date('mdYHis') . uniqid();
        $name = $filename . $formato;

        //creo un archivo temporal vacio con el nuevo nombre en la carpeta que iene permisos de escritura
        $ifp = fopen($path . $name, "wb");
        //escribo en el nuevo archivo el contenido despues de la coma
        fwrite($ifp, base64_decode($data[1])); //docodificando el base64
        //cierro el archivo
        fclose($ifp);
        return $fullpath ? $path . $name : $name;
    }

    public function eliminarFile($file_path)
    {
        //Elimino archivo si existe
        if (File::exists($file_path))
            File::delete($file_path);
    }
}