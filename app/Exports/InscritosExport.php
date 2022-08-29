<?php

namespace App\Exports;

use App\Models\Inscrito;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InscritosExport implements FromCollection, WithHeadings, WithMapping
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
            'Nombre',
            'Cantón',
            'Parroquia',
            'Teléfono',
            'Creado',
        ];
    }

    /**
     * @var User $usuario
     */
    public function map($usuario): array
    {
        return [
            $usuario->id,
            $usuario->nombre,
            $usuario->parroquia->canton->nombre,
            $usuario->parroquia->nombre,
            $usuario->telefono,
            $usuario->created_at
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usuarios = Inscrito::paraReporte($this->request);
        return  $usuarios->get();
    }
}
