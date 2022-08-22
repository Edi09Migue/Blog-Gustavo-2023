<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\Provincia;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Optix\Media\MediaUploader;
use Optix\Media\Models\Media;

class Provincias extends Controller
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
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc == "true" ? true : false) : false;

        //Obtengo una instancia de Usuarios para el query
        $provincias = Provincia::with('pais')
                                ->withCount('cantones');

        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if ($estado != '') {
            $provincias = $provincias->where('estado', $estado);
        }

        //Filtros basicos, orden y paginacion
        $provincias = $provincias->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('gid0', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'items' => $provincias->items(),
            'total' => $provincias->total()
        ]);
    }


    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las provinicias
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $provincias = Provincia::select('id', 'nombre', 'gid0', 'gid1')->get();

        return response()->json($provincias);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Geo\Provincia  $povincia
     * @return \Illuminate\Http\Response
     */
    public function show(Provincia $provincia)
    {
        $provincia->pais;
        
        return response()->json($provincia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Geo\Provincia  $provincia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Provincia $provincia)
    {
        $provincia->fill($request->except('imagen', 'imagenes'));

        //Elimino imagen si fue quitado del formulario
        if ($request->has('eliminar_imagen') && $request->eliminar_imagen) {
            parent::eliminarFile(public_path() . '/images/provincias/' . $provincia->imagen);
            $provincia->imagen = null;
        }

        if ($request->has('imagen') && !is_null($request->imagen)) {
            $provincia->imagen = parent::uploadAvatar($request->imagen, 'portada_' . $provincia->slug, '/images/provincias/');
        }

        if ($request->has('imagenes') && !is_null($request->imagenes)) {
            foreach ($request->imagenes as $imagen) {
                $filename = 'provincia_' . $provincia->slug . date('ymdhis');
                $uploaded = parent::uploadAvatar($imagen, $filename, '/images/provincias/', true);
                $origen = new UploadedFile($uploaded, $filename);
                $media = MediaUploader::fromFile($origen)
                    //->useFileName($imagen_name)
                    ->useName($provincia->nombre)
                    ->upload();
                $provincia->attachMedia($media);
            }
        }

        //Elimino las imagenes quitadas de la galeria 
        if ($request->has('imagenes_eliminadas')) {
            foreach ($request->imagenes_eliminadas as $id) {
                $img = Media::find($id);
                $img->delete();
            }
        }

        $provincia->save();

        return response()->json([
            'status' => true,
            'data' => $provincia,
            'msg' => 'Provincia actualizada correctamente!'
        ]);
    }
}
