<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\User;
use App\Models\Excusas;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AutorizacionExcusaComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filtro_estado = 'REGISTRADO';
    public  $padre_id, $grado, $tecnica, $motivo, $fecha_final, $fecha_inicial, $horas,  $fecha_radicado, $selected_id;
    public $estudiante_id = 2;
     public $buscar;
     public $cantidad_registros = 10;

     protected $listeners = ['autorizacion'];

     public function autorizacion()
     {
        $this->render();
     }

    public function render()
    {
        Gate::authorize('Autorización Excusas');
        if (!Auth::user()) {
            return redirect('/');
        }
        $excusas = Excusas::search($this->buscar)->status($this->filtro_estado)->orderBy('created_at', 'desc')
        ->paginate($this->cantidad_registros);
        return view('livewire.seguridad.autorizacion-excusa-component', compact('excusas'))->extends('adminlte::page');
    }

    public function autorizaciondatos($excusa){

        $this->emit('excusaEvent', $excusa);

    }


}
