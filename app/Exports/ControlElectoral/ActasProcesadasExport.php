<?php

namespace App\Exports\ControlElectoral;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class ActasProcesadasExport implements FromView
{
    public $vista_reporte;
    public $datos_reporte;

    public function __construct($vista_reporte, $datos_reporte)
    {
        $this->vista_reporte = $vista_reporte;
        $this->datos_reporte = $datos_reporte;
    }

    public function view(): View
    {
        return view($this->vista_reporte, $this->datos_reporte);
    }
   
}