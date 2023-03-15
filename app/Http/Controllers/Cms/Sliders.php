<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Sliders extends Controller
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
        $sliders = Slider::query();

        //Filtros basicos, orden y paginacion
        $sliders = $sliders->where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")
                ->orWhere('title_2', 'like', "%$query%")
                ->orWhere('subtitle', 'like', "%$query%")
                ->orWhere('descripcion', 'like', "%$query%")
                ->orWhere('url', 'like', "%$query%")
                ->orWhere('texto_boton', 'like', "%$query%")
                ->orWhere('externo', 'like', "%$query%")
                ->orWhere('orden', 'like', "%$query%")
                ->orWhere('visible', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'sliders' => $sliders->items(),
            'total' => $sliders->total()
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
            'orden' => 'required',
            'visible' => 'required',
        ],[],[ 
            'orden' => 'órden',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }

        $slider = new Slider($request->all());
        $slider->save();

        //Imagen
        if ($request->has('imagen') && !is_null($request->imagen)) {
            $upload_folder = '/images/cms/sliders/';
            parent::uploadAndConvert($request->imagen, $upload_folder, $slider, 'main', 'visible');
        }

        return response()->json([
            'status'    => TRUE,
            'msg'       => "Slider: {$slider->title}",
            'data'      => $slider
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return response()->json([
            'status'    => TRUE,
            'data'      => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $validator = Validator::make($request->all(), [
            'orden' => 'required',
            'visible' => 'required',
        ],[],[
            'orden' => 'órden',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => false,
                'data' => $errors,
                'msg' => $errors->first()
            ]);
        }
      
        $slider->fill($request->all());
        $slider->save();

        
        //Imagen
        if ($request->has('imagen') && !is_null($request->imagen)) {
        //Path donde se va a subir el archivo
        $upload_folder = '/images/cms/sliders/';
        //Subo la imagen en base 64 y la asigno como 'Mediable'
        parent::uploadAndConvert($request->imagen, $upload_folder, $slider, 'main', 'visible');
        }
   
        return response()->json([
            'status'    => TRUE,
            'msg'       => "Slider: {$slider->title}",
            'data'      => $slider
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return response()->json([
            'status'    => TRUE,
            'msg'       => "Slider: {$slider->title}",
            'data'      => $slider
        ]);
    }

    /**
     * Devuelve el id, nombre  de todos las sliders
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $slider = Slider::select('title','subtitle','id', 'texto_boton', 'url', 'externo')->where('visible',1)->orderBy('orden', 'asc')->get();
        return response()->json($slider);
    }










}
