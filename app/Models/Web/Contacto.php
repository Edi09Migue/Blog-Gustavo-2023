<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class Contacto extends Model implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;

    use HasFactory, SoftDeletes;
    
    protected $table = "contactos";

    protected $fillable  = [
        'nombre',
        'telefono',
        'email',
        'mensaje',
        'estado',
    ];

    protected $casts = [
        'estado' =>  'boolean'
    ];

    protected $appends = [
        'fechaRegistro',
        'privateURL',
    ];

    /**
     * Formatear fecha Registro
    */
    public function getFechaRegistroAttribute(){

        $fecha = Carbon::parse($this->created_at);

        $fecha->diffForHumans(); 

        $fecha->isoFormat('LL');

        return $fecha;
    }

    /**
     * Ruta para filtrar un contacto
    */
    public function getPrivateURLAttribute(){
        $url = url('admin/web/contactos/list');
        return $url;
    }

}
