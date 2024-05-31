<?php

namespace App\Http\Livewire\Seguridad;

use Carbon\Carbon;
use App\Models\Excusas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class ExcusasGeneralesComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filtro_grado, $desde, $hasta ;
    public  $padre_id, $grado, $tecnica, $motivo, $fecha_final, $fecha_inicial, $horas,  $fecha_radicado, $selected_id, $filtro_tecnica;
    public $estudiante_id = 2;
     public $select_grado, $select_letra;
     public $cantidad_registros = 10;
    public function render()
    {
        Gate::authorize('Excusas Aprovadas');
        $hoy = Carbon::now();
        $hoy->locale('es'); // Establecer la localización en español
        $hoy = $hoy->format('Y-m-d');
        $this->updatedSelectGrado();

        $excusas = Excusas::whereBetween('created_at', [$this->desde, $this->hasta])
        ->grado($this->filtro_grado)
        ->tecnica($this->filtro_tecnica)
        ->paginate($this->cantidad_registros);


        return view('livewire.seguridad.excusas-generales-component', compact('excusas','hoy'))->extends('adminlte::page');
    }

    public function updatedSelectGrado(){
        if($this->select_letra && $this->select_grado){
            $this->filtro_grado = $this->select_grado.$this->select_letra;
        }
    }

    public function autorizaciondatos($excusa){
        $this->emit('excusaEvent', $excusa);
    }
}
