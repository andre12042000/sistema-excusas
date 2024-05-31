<?php

namespace App\Http\Livewire\Seguridad;

use Carbon\Carbon;
use App\Models\Excusas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProfesorExcusaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filtro_grado ;
    public  $padre_id, $grado, $tecnica, $motivo, $fecha_final, $fecha_inicial, $horas,  $fecha_radicado, $selected_id, $filtro_tecnica;
    public $estudiante_id = 2;
     public $select_grado, $select_letra, $filtro_motivo;
     public $cantidad_registros = 10;

     public function render()
        {

            Gate::authorize('Excusas Aprovadas');
            $hoy = Carbon::now();
            $hoy->locale('es'); // Establecer la localización en español
            $hoy = $hoy->format('Y-m-d');
            $this->updatedSelectGrado();

            $excusas = Excusas::where(function ($query) use ($hoy) {
                $query->where('fecha_inicial', '>=', $hoy)
                      ->orWhere('fecha_final', '>=', $hoy);

            })
            ->Where('status', 'APROVADO')
            ->grado($this->filtro_grado)
            ->tecnica($this->filtro_tecnica)
            ->motivo($this->filtro_motivo)
            ->paginate($this->cantidad_registros);

            return view('livewire.seguridad.profesor-excusa-component', compact('excusas','hoy'))->extends('adminlte::page');
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
