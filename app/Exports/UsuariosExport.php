<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Illuminate\Http\Request;

class UsuariosExport implements FromCollection, WithHeadings, WithMapping
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;        
    }
    /**
     * Define los nombres para la primera fila de cada columna
     */
    public function headings(): array
    {
        return [
            'Id',
            'Cédula',
            'Nombre',
            'Email',
            'Teléfono',
            'Rol',       
            'Creado',
            'Actualizado',
        ];
    }

        /**
    * @var User $usuario
    */
    public function map($usuario): array
    {
        $roles = '';
        foreach($usuario->roles as $rol){
            $roles .= $rol->name;
        }
         
        return [
            $usuario->id,
            $usuario->cedula,
            $usuario->name,
            $usuario->email,
            $usuario->telefono,
            $roles,
            $usuario->created_at,
            $usuario->updated_at,
        ];
    }


    /**
    * Devuelve las usuarios filtrados para ser mapeados con map()
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usuarios = User::whereDate('created_at', '>=',$this->request->desde)
        ->whereDate('created_at','<=', $this->request->hasta);

        //si se ha seleccionado algun rol
        if ($this->request->has('roles') && !empty($this->request->roles)) {
            $usuarios->role($this->request->roles);
        }
        return  $usuarios->get();
        
    }
}
