<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ContactoStoreRequest;
use App\Models\Configuracion;
use App\Models\Web\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Mail\ContactoMail;
use App\Models\User;
use App\Notifications\Web\ContactoCreatedNotification;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\DB;

class Contactos extends Controller
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
        $categorias = Contacto::query();

        //Filters
        $contactoId = $request->has('id') ? $request->id : '';
        if ($contactoId != '') {
            $categorias = $categorias->where('id', $request->id);
        }

        //Filtros basicos, orden y paginacion
        $categorias = $categorias->where(function ($q) use ($query) {
            $q->where('nombre', 'like', "%$query%")
                ->orWhere('telefono', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->orWhere('mensaje', 'like', "%$query%");
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
    public function store(ContactoStoreRequest $request)
    {  
        DB::beginTransaction();

        try {

            $contacto = new Contacto($request->all());
            $contacto->save();

            $contactoEmail = new ContactoMail($contacto);

            //envío al suscriptor
            Mail::to($request->email)->send($contactoEmail);
            //envío al administrador
            $email_admin = Configuracion::valor('email_admin');
            Mail::to($email_admin)->send($contactoEmail);

            // $usuarios = User::ConRol(['Admin','Superadmin', 'Comunicación'])->get();
            // foreach ($usuarios as $key => $notificarA) {
            //     # code...
            //     $notificarA->notify(new ContactoCreatedNotification($contacto));
            // }
            
            DB::commit();

            return response()->json([
                'status'    => TRUE,
                'msg'       => "{$contacto->nombre} gracias por contactarte",
                'data'      => $contacto,
            ]);

        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'msg' => 'Error al contáctarce!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function show(Contacto $contacto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function update(ContactoStoreRequest $request, Contacto $contacto)
    {
        if ($request->updateEstado) {
            $contacto->fill($request->all());
            $contacto->save();
        } else {
            $contacto->fill(Arr::except($request->all(), ['estado']));
            $contacto->save();
        }

        return response()->json([
            'status'    => TRUE,
            'msg'       => "Contacto: {$contacto->nombre}",
            'data'      => $contacto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contacto  $contacto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacto $contacto)
    {
        //
    }

    /**
     * Configuraciones para el formulario
     */
     public function configuraciones(){
        $data = [
            'contacto_nuevo' => Configuracion::valor('contacto_nuevo'),
            'contacto_mensaje_final' => Configuracion::valor('contacto_mensaje_final'),
        ];
    
        return response()->json([
            'status'    => TRUE,
            'data'      => $data
        ]);
    }

    public function enviarContactoEmail(Contacto $contacto, Request $request)
    {
        // Maquetado
        return (new ContactoMail($contacto))->render();
        // Envio
        $contactoEmail = new ContactoMail($contacto);
        $enviado = Mail::to($request->email)->send($contactoEmail);
        return response()->json([
            'status'    =>  true,
            'data'     =>  $enviado
        ]);
    }
}
