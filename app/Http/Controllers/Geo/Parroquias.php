<?php

namespace App\Http\Controllers\Geo;

use App\Http\Controllers\Controller;
use App\Models\Geo\Parroquia;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
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
        $sortBy = $request->has('sortBy') ? ($request->sortBy == "" ? "id" : $request->sortBy) : "id";
        $sortDesc = $request->has('sortDesc') ? ($request->sortDesc == "true" ? true : false) : false;

        //Obtengo una instancia de Usuarios para el query
        $parroquias = Parroquia::query();

        //Filtro para Estado
        $estado = $request->has('estado') ? $request->estado : '';
        if ($estado != '') {
            $parroquias = $parroquias->where('estado', $estado);
        }

        //Filtro para Provincia
        $provincia = $request->has('provincia') ? $request->provincia : '';
        if ($provincia != '') {
            $parroquias = $parroquias->where(function ($q) use ($provincia) {
                $q->whereIn('gid1', function ($sq) use ($provincia) {
                    $sq->select('gid1');
                    $sq->from('provincias');
                    $sq->where('id', $provincia);
                });
            });
        }

        //Filtro para Canton
        $canton = $request->has('canton') ? $request->canton : '';
        if ($canton != '') {
            $parroquias = $parroquias->where(function ($q) use ($canton) {
                $q->whereIn('gid2', function ($sq) use ($canton) {
                    $sq->select('gid2');
                    $sq->from('cantones');
                    $sq->where('id', $canton);
                });
            });
        }

        //Filtros basicos, orden y paginacion
        $parroquias = $parroquias->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('gid3', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        $parroquias->each(function ($p) {
            $p->canton;
            $p->iconoURL = $p->iconoURL;
            $p->provincia = $p->canton->provincia;
        });

        return response()->json([
            'users' => $parroquias->items(),
            'total' => $parroquias->total()
        ]);
    }


    /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las parroquias
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions(Request $request)
    {
        $parroquias = Parroquia::select('id', 'nombre', 'gid0', 'gid1', 'gid2', 'gid3');
        //en caso de querer solo las parroquias de un canton
        if ($request->has('gid2'))
            $parroquias = $parroquias->where('gid2', $request->gid2);

            $parroquias = $parroquias->get();


        return response()->json([
            'status' => true,
            'items' => $parroquias,
        ]);
    }


  
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Geo\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function show(Parroquia $parroquia)
    {
        $parroquia->canton;
        return response()->json($parroquia);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $parroquia = new Parroquia($request->all());
            $parroquia->nombre = $parroquia->nombre.' duplicada';
            $parroquia->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $parroquia,
                'msg' => $parroquia->nombre . ' duplicada!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $e->getMessage(),
                'msg' => 'Error al duplicar Parroquia!'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Geo\Parroquia  $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        $parroquia->fill($request->except('imagen', 'imagenes'));

        //Elimino imagen si fue quitado del formulario
        if ($request->has('eliminar_imagen') && $request->eliminar_imagen) {
            parent::eliminarFile(public_path() . '/images/parroquias/' . $parroquia->imagen);
            $parroquia->imagen = null;
        }

        if ($request->has('imagen') && !is_null($request->imagen)) {
            $parroquia->imagen = parent::uploadAvatar($request->imagen, 'portada_' . $parroquia->slug, '/images/parroquias/');
        }



        if ($request->has('imagenes') && !is_null($request->imagenes)) {
            foreach ($request->imagenes as $imagen) {
                $filename = 'parroquia_' . $parroquia->slug . date('ymdhis');
                $uploaded = parent::uploadAvatar($imagen, $filename, '/images/parroquias/', true);
                $origen = new UploadedFile($uploaded, $filename);
                $media = MediaUploader::fromFile($origen)
                    //->useFileName($imagen_name)
                    ->useName($parroquia->nombre)
                    ->upload();
                $parroquia->attachMedia($media);
            }
        }

        //Elimino las imagenes quitadas de la galeria 
        if ($request->has('imagenes_eliminadas')) {
            foreach ($request->imagenes_eliminadas as $id) {
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


     /**
     * Devuelve el id, nombre, gid0 y gid1 de todas las parroquias
     * por lo general para usarlos en un componente dropdown
     */
    public function parroquiasOptionsActas(Request $request)
    {
        $parroquias = Parroquia::select('id', 'nombre', 'gid0', 'gid1', 'gid2', 'gid3')->orderBy('nombre','asc')->withCount('recintos');
        //en caso de querer solo las parroquias de un canton
        if ($request->has('gid2'))
            $parroquias = $parroquias->where('gid2', $request->gid2);

            $parroquias = $parroquias->get();


        return response()->json([
            'status' => true,
            'items' => $parroquias,
        ]);
    }

 


}
