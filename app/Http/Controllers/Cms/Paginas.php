<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Pagina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Paginas extends Controller
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
        $paginas = Pagina::with('usuario')
                        ->with('categorias');

        //Filtros basicos, orden y paginacion
        $paginas = $paginas->where(function ($q) use ($query) {
            $q->where('titulo', 'like', "%$query%")
                ->orWhere('slug', 'like', "%$query%")
                ->orWhere('contenido', 'like', "%$query%")
                ->orWhere('fecha', 'like', "%$query%")
                ->orWhere('user_id', 'like', "%$query%")
                ->orWhere('estado', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'paginas' => $paginas->items(),
            'total' => $paginas->total()
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
            'titulo' => 'required',
            'contenido' => 'required',
            'fecha' => 'required',
            'estado' => 'required',
        ],[],[
            'user_id' => 'usuario',  
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        $pagina = new Pagina($request->all());
        //Guardar el usuario que creo la pàgina desde el controlador
        $pagina->user_id = Auth::user()->id;
        $pagina->save();

        //Imagen
        if ($request->has('imagen') && !is_null($request->imagen)) {
            $upload_folder = '/images/cms/articulos/';
            parent::uploadAndConvert($request->imagen, $upload_folder, $pagina, 'main', 'titulo');
        }
        //Guardar categorías de la página
        $pagina->categorias()->sync($request->categorias);

        return response()->json([
            'status'    => TRUE,
            'msg'       => "Artículo: {$pagina->titulo}",
            'data'      => $pagina
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function show(Pagina $pagina)
    {
        //Envío las categorías para editar
        $pagina->categorias;
        $pagina->usuario;
        
        //Array con los ids de las categorias
        //pluck obtener solo los id del objeto
        $idsCategorias = $pagina->categorias()->select('categorias_blog.id')->get()->pluck('id');
        //igualos el id de la pagina con el ide de la categoria
        // campo condición u valor del primer where para exluir la pagina
        $paginas = Pagina::where('id',"!=",$pagina->id )
                        ->whereIn('id',function ($sq) use ($idsCategorias) {
                            $sq->select('pagina_id');
                            $sq->from('categoria_paginas');
                            $sq->wherein('categoria_id', $idsCategorias);
                            //take contolar cuantos se envíam
                        })->where('estado','publicada')
                        ->take(5)
                        ->get();

        $pagina->relacionadas = $paginas;
        //dd($paginas);
   
        return response()->json([
            'status'    => TRUE,
            'data'      => $pagina
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pagina $pagina)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'contenido' => 'required',
            'fecha' => 'required',
            'user_id' => 'required',
            'estado' => 'required',
        ],[],[
            'user_id' => 'usuario',  
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        //Imagen
        if ($request->has('imagen') && !is_null($request->imagen)) {
        //Path donde se va a subir el archivo
        $upload_folder = '/images/cms/articulos/';
        //Subo la imagen en base 64 y la asigno como 'Mediable'
        parent::uploadAndConvert($request->imagen, $upload_folder, $pagina, 'main', 'titulo');
        }

        //Guardar categorías de la página
        $pagina->categorias()->sync($request->categorias);

        $pagina->fill($request->all());
        $pagina->save();

        return response()->json([
            'status'    => TRUE,
            'msg'       => "Artículo: {$pagina->titulo}",
            'data'      => $pagina
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Pagina  $pagina
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagina $pagina)
    {
        $pagina->delete();
        return response()->json([
            'status'    => TRUE,
            'msg'       => "Artículo: {$pagina->titulo}",
            'data'      => $pagina
        ]);
    }

    /**
     * Devuelve el id, nombre  de todos las páginas
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $pagina = Pagina::select('titulo','slug','id')->where('estado','publicada')->orderBy('titulo', 'asc')->get();
        return response()->json($pagina);
    }
     
}
