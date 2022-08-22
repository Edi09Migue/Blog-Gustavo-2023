<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\Canton;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Optix\Media\MediaUploader;
use Optix\Media\Models\Media;

class Cantones extends Controller
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

        //Obtengo una instancia de Canton para el query
        $cantones = Canton::with('provincia')
                            ->withCount('parroquias');

        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if ($estado != '') {
            $cantones = $cantones->where('estado', $estado);
        }


        //Filtro para Provincia
        $provincia = $request->has('provincia') ? $request->provincia : '';
        if ($provincia != '') {
            $cantones = $cantones->where(function ($q) use ($provincia) {
                $q->whereIn('gid1', function ($sq) use ($provincia) {
                    $sq->select('gid1');
                    $sq->from('provincias');
                    $sq->where('id', $provincia);
                });
            });
        }


        //Filtros basicos, orden y paginacion
        $cantones = $cantones->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('gid1', 'like', "%$query%")
                ->orWhere('gid2', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'users' => $cantones->items(),
            'total' => $cantones->total()
        ]);
    }


    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las cantones
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions(Request $request)
    {
        $cantones = Canton::select('id', 'nombre', 'gid0', 'gid1', 'gid2');

        //en caso de querer solo los cantones de una provincia
        if ($request->has('gid1'))
            $cantones = $cantones->where('gid1', $request->gid1);

        $cantones = $cantones->where('estado',true)->get();

        return response()->json($cantones);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Geo\Canton  $cantone
     * @return \Illuminate\Http\Response
     */
    public function show(Canton $cantone)
    {
        $cantone->provincia;
        return response()->json($cantone);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Geo\Canton  $cantone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Canton $cantone)
    {
        $cantone->fill($request->except('imagen', 'imagenes'));

        //Elimino imagen si fue quitado del formulario
        if ($request->has('eliminar_imagen') && $request->eliminar_imagen) {
            parent::eliminarFile(public_path() . '/images/cantones/' . $cantone->imagen);
            $cantone->imagen = null;
        }

        if ($request->has('imagen') && !is_null($request->imagen)) {
            $cantone->imagen = parent::uploadAvatar($request->imagen, 'portada_' . $cantone->slug, '/images/cantones/');
        }

        if ($request->has('imagenes') && !is_null($request->imagenes)) {
            foreach ($request->imagenes as $imagen) {
                $filename = 'canton_' . $cantone->slug . date('ymdhis');
                $uploaded = parent::uploadAvatar($imagen, $filename, '/images/cantones/', true);
                $origen = new UploadedFile($uploaded, $filename);
                $media = MediaUploader::fromFile($origen)
                    //->useFileName($imagen_name)
                    ->useName($cantone->nombre)
                    ->upload();
                $cantone->attachMedia($media);
            }
        }

        //Elimino las imagenes quitadas de la galeria 
        if ($request->has('imagenes_eliminadas')) {
            foreach ($request->imagenes_eliminadas as $id) {
                $img = Media::find($id);
                $img->delete();
            }
        }

        $cantone->save();

        return response()->json([
            'status' => true,
            'data' => $cantone,
            'msg' => 'Cantón actualizado correctamente!'
        ]);
    }
}
