<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Acta;
use App\Models\ControlElectoral\CandidatoActa;
use App\Models\ControlElectoral\Junta;
use App\Models\ControlElectoral\Candidato;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ActaStoreRequest;

class Actas extends Controller
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
        $actas = Acta::with('junta.recinto.parroquia');

        //Si es admin o superadmin muestro las borradas
        if(Auth::user()->isAdmin){
            $actas = $actas->withTrashed();
        }

        //Filtro parroquia
        if ($request->has('parroquia')) {
            //soporte para buscar una o varias parroquias
            $parroquiasIds = is_array($request->parroquia) ? $request->parroquia : [$request->parroquia];
          
            $actas = $actas->whereIn('junta_id', function($q) use ($parroquiasIds){
                $q->select('id');
                $q->from('juntas');
                $q->whereIn('recinto_id', function($sq) use ($parroquiasIds){
                    $sq->select('id');
                    $sq->from('recintos');
                    $sq->whereIn('parroquia_id', $parroquiasIds);
                });
            });
        }


        //Filtro recinto
        $recinto = $request->has('recinto') ? $request->recinto : '';
        if ($recinto != '') {
            $actas = $actas->whereIn('junta_id', function($q) use ($recinto){
                $q->select('id');
                $q->from('juntas');
                $q->where('recinto_id', $recinto);
            });
        }

        //Filtro junta
        $junta = $request->has('junta') ? $request->junta : '';
        if ($junta != '') {
            $actas = $actas->where('junta_id', $junta);
        }

        
        //Filtro estado actas
        $estado = $request->has('estado') ? $request->estado : '';
        if ($estado != '') {
            if($estado == 'inconsistentes'){
                $inconsistente = true;
            }else if ($estado == 'consistentes'){
                $inconsistente = false;
            }
            $actas = $actas->where('inconsistente',   $inconsistente);
        }


        //Filtros basicos, orden y paginacion
        $actas = $actas->where(function ($q) use ($query) {
            $q->where('codigo', 'like', "%$query%")
            ->orWhereIn('junta_id', function ($q) use ($query) {
                $q->select('id');
                $q->from('juntas');
                $q->where('codigo','like', "%$query%");
                $q->orWhereIn('recinto_id', function($q) use ($query){
                    $q->select('id');
                    $q->from('recintos');
                    $q->where('codigo', 'like', "%$query%");
                    $q->orWhere('nombre', 'like', "%$query%");
                });
            });
            

        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);
        

        return response()->json([
            'status' => true,
            'items' => $actas->items(),
            'total' => $actas->total()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActaStoreRequest $request)
    {
      
        DB::beginTransaction();
        try {

            $acta = new Acta($request->all());

            #Generar código del acta a guardar
            $junta = Junta::where('id',$acta->junta_id)->first();

            if($junta){
                $recinto = $junta->recinto;
                $codigo =  strtoupper($recinto->codigo.'-'.$junta->codigo.substr($junta->tipo,0,1));
            }

            #Verificar si la acta no fue ingresar 
            $existsActa = Acta::where('codigo',$acta->codigo)->first();
            
            if(!$existsActa){ #Si no fue ingresada guardar

                $acta->codigo = $codigo;
                $acta->save();

                if ($request->has('imagen') && !is_null($request->imagen)) {
                    $upload_folder = '/images/control_electoral/actas/';
                    parent::uploadAndConvert($request->imagen, $upload_folder, $acta, 'main', 'codigo');
                }

                $msg = "Acta: {$acta->codigo}";
                $status = true;

            }else{ #Si fue ingresada enviar un mensaje al usuario
                $msg = "El acta {$codigo} ya fue ingresada";
                $status = false;
            }

            DB::commit();
            return response()->json([
                'status'    => $status,
                'msg'       => $msg,
                'data'      => $acta
            ]);

        }catch (Exception  $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'acta'=>$acta,
                'msg' => 'Error al crear acta'
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gaceta\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function show(Acta $acta)
    {
        $acta->junta->recinto->parroquia;
        $acta->ingresada;


        $candidatosActa = CandidatoActa::where('acta_id',  $acta->id)->get();

        $acta->candidatos_acta = $candidatosActa;

        $total_votos = 0;
        $procesada = null;
        foreach($candidatosActa as $candidato_acta){
            $candidato_acta->candidato;
            $procesada  = $candidato_acta->procesada->name;
            $total_votos += $candidato_acta->votos;
        }
        $acta->procesada = $procesada;
        $acta->total_votos = $total_votos;


        return response()->json([
            'status'    => TRUE,
            'data'      => $acta
        ]);
    }

    /**
     * Display last acta.
     *
     * @return \Illuminate\Http\Response
     */
    public function lastActa(Request  $request)
    {
        
        #Una acta visulazada es cuando el row visualizado de la tabla acta es true

        #Seleccionar una acta que fue visulazada pero no fue guardada
        $acta = Acta::where('estado', false)->where('visualizado', true)->where('visualizado_por', $request->user)->orderBy('id', 'asc')->first();
        if(!$acta)
            #Seleccionar una acta que fue no fue visulazada
            $acta = Acta::where('estado', false)->where('visualizado', false)->orderBy('id', 'asc')->first();

        #Actualizar el row  visualizado a true, PARA que otro usuario no consulte la misma
        if ($acta) {
            $acta->update(['visualizado'=>true,'visualizado_por'=>$request->user]);
            $status = true;
        }else{
            $status = false;
        }
        
        #Seleccionara los candidatos
        $candidatos = Candidato::all();
        
        return response()->json([
            'status'    => $status,
            'acta'      => $acta,
            'candidatos'=> $candidatos,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Acta $acta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acta $acta)
    {

        DB::beginTransaction();
        try {

            #actualiza los campos
            $acta->update(['votos_blancos' => $request->acta['votos_blancos'],
                          'votos_nulos' => $request->acta['votos_nulos'],
                          'total_votantes' => $request->acta['total_votantes'],
                          'inconsistente' => $request->acta['inconsistente'],
                          'estado' => true]);

            #Guardar los votos para los candidatos
            if ($request->has('candidatos_votos')) {
                foreach ($request->candidatos_votos as $item) {
                    CandidatoActa::create([
                        "candidato_id" => $item['candidato_id'],
                        "acta_id" => $item['acta_id'],
                        "votos" => $item['votos'],
                        "procesada_por" => $item['procesada_por'],
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status'    => TRUE,
                'msg'       => "Acta: {$acta->codigo}",
                'data'      => $acta
            ]);

        }catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'msg' => 'Error al crear acta'
            ]);
        } 
    
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gaceta\Acta $acta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acta $acta)
    {
        $acta->delete();

        return response()->json([
            'status'    => TRUE,
            'data'      => $acta,
            'msg'       => "Acta: {$acta->codigo}"
        ]);
    }

    /**
     * Restaura el elemento borrado
    */
    public function restore($acta){

        $acta = Acta::withTrashed()->find($acta);
        
        $acta->restore();

        return response()->json([
            'status' => true,
            'data' => $acta,
            'msg'       => "Acta: {$acta->codigo}"

        ]);
    }

    /**
     * Devuelve todas las actas
     * por lo general para actas en un componente dropdown
     */
    public function dropdownOptions(Request $request)
    {
        $actas = Acta::orderBy('id', 'asc');
        
        #Actas por junta
        if ($request->has('junta'))
            $actas = $actas->where('junta_id', $request->junta);
        
        $actas = $actas->get();

        return response()->json([
            'status'    =>  true,
            'items'     =>  $actas
        ]);
    }



    /**
     * Devuelve las opciones de los estados de las actas inconsistentes y consistentes
     */
    public function estadosOptions()
    {

        $estados =  [
            [
                'label'     =>  'Inconsistes',
                'value'     =>  'inconsistentes',
                'actas_count'      =>  Acta::where('inconsistente', true)->count(),
            ],
            [
                'label'     =>  'Consistentes',
                'value'     =>  'consistentes',
                'actas_count'      =>  Acta::where('inconsistente', false)->count(),
            ],




        ];


        return response()->json([
            'status'    =>  true,
            'items'     =>  $estados
        ]);
    }

}
