<?php

namespace App\Http\Controllers\ControlElectoral;

use App\Http\Controllers\Controller;
use App\Models\ControlElectoral\Acta;
use App\Models\ControlElectoral\CandidatoActa;
use App\Models\ControlElectoral\Junta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $parroquia = $request->has('parroquia') ? $request->parroquia : '';
        if ($parroquia != '') {
            $actas = $actas->whereIn('junta_id', function($q) use ($parroquia){
                $q->select('id');
                $q->from('juntas');
                $q->whereIn('recinto_id', function($sq) use ($parroquia){
                $sq->select('id');
                $sq->from('recintos');
                $sq->where('parroquia_id', $parroquia);
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


        //Filtros basicos, orden y paginacion
        $actas = $actas->where(function ($q) use ($query) {
            $q->where('codigo', 'like', "%$query%")
                ->orWhereIn('junta_id', function ($q) use ($query) {
                    $q->select('id');
                    $q->from('juntas');
                    $q->where('codigo','like', "%$query%");
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
    public function store(Request $request)
    {
      
        DB::beginTransaction();
        try {

            dd($request->all());

            $acta = new Acta($request->all());
            
            //generar código
            $junta = Junta::where($acta->junta_id)->first();

            if($junta){
                $recinto = $junta->recinto;
                $codigo =  $recinto->codigo.'-'.$junta->codigo;
                $acta->codigo = $codigo;
            }

            $acta->ingresada_por = Auth::user()->id;

            $acta->save();


             //Imagen
            if ($request->has('imagen') && !is_null($request->imagen)) {
                $upload_folder = '/images/control_electoral/actas/';
                parent::uploadAndConvert($request->imagen, $upload_folder, $acta, 'main', 'codigo');
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

    //

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
            // $acta->fill($request->all());

            //actualiza los campos
            $acta->update(['votos_blancos' => $request->votos_blancos,
                          'votos_nulos' => $request->votos_nulos,
                          'votos_validos' => $request->votos_validos,
                          'estado' => true]);

            // $acta->save();

            //Votos para los candidatos
            if ($request->has('candidatos')) {
                foreach ($request->candidatos as $candidato) {
                    CandidatoActa::create([
                        "candidato_id" => $candidato['candidato_id'],
                        "acta_id" => $candidato['acta_id'],
                        "votos" => $candidato['votos'],
                        "procesada_por" =>  Auth::user()->id,
              
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
     * por lo general para usarlos en un componente dropdown
     */
    public function dropdownOptions()
    {
        $acta = Acta::orderBy('id', 'asc')->get();
        return response()->json([
            'status'    =>  true,
            'items'     =>  $acta
        ]);
    }









}
