<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SuscriptorStoreRequest;
use App\Mail\EnvioSuscriptorMail;
use App\Models\Configuracion;
use App\Models\User;
use App\Models\Web\Suscriptor;
use App\Notifications\Web\SuscriptorCreadoNotificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class Suscriptores extends Controller
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
        $suscriptores = Suscriptor::query();

             
        //Filters
        $suscriptorId = $request->has('id') ? $request->id : '';
        if ($suscriptorId != '') {
            $suscriptores = $suscriptores->where('id', $request->id);
        }

        //Filtros basicos, orden y paginacion
        $suscriptores = $suscriptores->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->orWhere('telefono', 'like', "%$query%");
        })
            ->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'items' => $suscriptores->items(),
            'total' => $suscriptores->total()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuscriptorStoreRequest $request)
    {
        DB::beginTransaction();
        try {

            $suscriptor = new Suscriptor($request->all());
            $suscriptor->save();

            
            $suscriptorEmail = new EnvioSuscriptorMail($suscriptor);
            //envío al suscriptor
            Mail::to($request->email)->send($suscriptorEmail);
            //envío al administrador
            $email_admin = Configuracion::valor('email_admin');
            Mail::to($email_admin)->send($suscriptorEmail);

            // Notificaciones
            // $usuarios = User::ConRol(['Admin','Superadmin', 'Comunicación'])->get();
            // foreach ($usuarios as $key => $userNotificar) {
            //     $userNotificar->notify(new SuscriptorCreadoNotificacion($suscriptor));
            // }

            DB::commit();
            if($request->ajax()){
                return response()->json([
                    'status'    => TRUE,
                    'msg'       => "{$suscriptor->nombre} gracias por suscribirte",
                    'data'      => $suscriptor
                ]);
            }else{
                return redirect()->route('front.contacto');

            }
           

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $e->getMessage(),
                'msg' => 'Error al suscribirse'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gaceta\Suscriptor  $suscriptor
     * @return \Illuminate\Http\Response
     */
    public function show(Suscriptor $suscriptor)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Suscriptor $suscriptor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suscriptor $suscriptor)
    {
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gaceta\Suscriptor $suscriptor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suscriptor $suscriptor)
    {
        $suscriptor->delete();
        return response()->json([
            'status'    => TRUE,
            'msg'       => "Suscriptor: {$suscriptor->nombre}",
            'data'      => $suscriptor
        ]);
    }

    /**
     * Envia un email de suscription al email especificado
    */
    public function enviarSuscriptorEmail(Suscriptor $suscriptor, Request $request)
    {

       
        // Maquetado
        return (new EnvioSuscriptorMail($suscriptor))->render();

        // Envio
        $suscriptorEmail = new EnvioSuscriptorMail($suscriptor);
        $enviado = Mail::to($request->email)->send($suscriptorEmail);

        return response()->json([
            'status'    =>  true,
            'data'     =>  $enviado
        ]);
    }



}
