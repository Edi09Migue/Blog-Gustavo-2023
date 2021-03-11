<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Parroquia;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Optix\Media\MediaUploader;
use Optix\Media\Models\Media;

class Parroquias extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Filtros para query
        $query = $request->has('q') ? $request->q : "";
        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "id";
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc=="true" ? true : false) : false;
        
        //Obtengo una instancia de Usuarios para el query
        $parroquias = Parroquia::query();
        
        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if($estado!='') {
            $parroquias = $parroquias->where('estado',$estado);
        }

        //Filtros basicos, orden y paginacion
        $parroquias = $parroquias->where(function($q) use($query){
            $q->where('nombre','like',"%$query%")
            ->orWhere('gid3','like',"%$query%");
        })
        ->orderBy($sortBy,$sortDesc?'desc':'asc')
        ->paginate($perPage);

        return response()->json([
            'users' => $parroquias->items(),
            'total'=>$parroquias->total()
        ]);
    }

        
    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las parroquias
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions(){
        $provincias = Parroquia::select('id','nombre','gid0','gid1','gid2','gid3')->get();

        return response()->json($provincias);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function show(Parroquia $parroquia)
    {
        
        return response()->json($parroquia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        $parroquia->fill($request->except('imagen','imagenes'));

        //Elimino imagen si fue quitado del formulario
        if($request->has('eliminar_imagen') && $request->eliminar_imagen){
            parent::eliminarFile(public_path().'/images/parroquias/'.$parroquia->imagen);
            $parroquia->imagen = null;
        }  

        if($request->has('imagen') && !is_null($request->imagen))
        {
            $parroquia->imagen = parent::uploadAvatar($request->imagen,'portada_'.$parroquia->slug,'/images/parroquias/');
        }

        
               
       if($request->has('imagenes') && !is_null($request->imagenes))
       {
           foreach($request->imagenes as $imagen){
               $filename = 'parroquia_'.$parroquia->slug.date('ymdhis');
               $uploaded = parent::uploadAvatar($imagen,$filename,'/images/parroquias/',true);
                $origen = new UploadedFile($uploaded,$filename);
                $media = MediaUploader::fromFile($origen)
                //->useFileName($imagen_name)
                ->useName($parroquia->nombre)
                ->upload();
                $parroquia->attachMedia($media);
           }
       }

        //Elimino las imagenes quitadas de la galeria 
        if($request->has('imagenes_eliminadas')){
            foreach($request->imagenes_eliminadas as $id){
                $img = Media::find($id);
                $img->delete();
            }
        }

        $parroquia->save();

        return response()->json([
            'status' => true,
            'data' => $parroquia,
            'msg' => 'Parroquia actualizada correctamente!'
        ]);
    }
}
