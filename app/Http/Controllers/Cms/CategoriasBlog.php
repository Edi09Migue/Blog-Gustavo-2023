<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\CategoriaBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriasBlog extends Controller
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

        //Obtengo una instancia de Pagina para el query
        $categorias = CategoriaBlog::query();

        //Filtros basicos, orden y paginacion
        $categorias = $categorias->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('descripcion', 'like', "%$query%")
                ->orWhere('slug', 'like', "%$query%")
                ->orWhere('estado', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'items' => $categorias->items(),
            'total' => $categorias->total()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
        ],[],[
            'descripcion' => 'descripción',  
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        $categoria = new CategoriaBlog($request->all());
        $categoria->save();

        //Imagen
         if ($request->has('imagen') && !is_null($request->imagen)) {
            $upload_folder = '/images/cms/categorias/';
            parent::uploadAndConvert($request->imagen, $upload_folder, $categoria, 'main', 'nombre');
        }

        return response()->json([
            'status'    => TRUE,
            'msg'       => "Categoría: {$categoria->nombre}",
            'data'      => $categoria
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\CategoriaBlog  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(CategoriaBlog $categoria)
    {
        return response()->json([
            'status'    => TRUE,
            'data'      => $categoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\CategoriaBlog  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoriaBlog $categoria)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required',
            'estado' => 'required',
        ],[],[
            'descripcion' => 'descripción',  
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }
      
        $categoria->fill($request->all());
        $categoria->save();

        
        //Imagen
        if ($request->has('imagen') && !is_null($request->imagen)) {
        //Path donde se va a subir el archivo
        $upload_folder = '/images/cms/categorias/';
        //Subo la imagen en base 64 y la asigno como 'Mediable'
        parent::uploadAndConvert($request->imagen, $upload_folder, $categoria, 'main', 'nombre');
        }
        //Elimino las imagenes quitadas de la galeria 
        if ($request->has('imagenes_eliminadas') && $request->imagenes_eliminadas == true) {
        //borro todas las imagenes de la coleccion especificada
          foreach ($categoria->getMedia('main') as $media) {
              $media->delete();
          }
        }
        return response()->json([
            'status'    => TRUE,
            'msg'       => "Categoría: {$categoria->nombre}",
            'data'      => $categoria
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\CategoriaBlog  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoriaBlog $categoria)
    {
        $categoria->delete();
        return response()->json([
            'status'    => TRUE,
            'data'      => $categoria,
            'msg'       => "Categoría: {$categoria->nombre}"
        ]);
    }

    /**
     * Devuelve el id, nombre  de todos las categiorias
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $categoria = CategoriaBlog::select('nombre','id')->orderBy('nombre', 'asc')->get();
        return response()->json($categoria);
    }


}
