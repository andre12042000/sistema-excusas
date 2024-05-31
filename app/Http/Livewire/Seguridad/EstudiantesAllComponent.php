<?php

namespace App\Http\Livewire\Seguridad;

use App\Models\Excusas;
use Livewire\Component;
use App\Models\Estudiantes;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EstudiantesAllComponent extends Component
{
    public $buscar;
    public $cantidad_registros = 10;
    public $name, $codigo, $grado, $padre_id, $selected_id, $numero, $letra, $tecnica;
    public $statusadministracion;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        Gate::authorize('Administración Estudiantes');
        if (!Auth::user()) {
            return redirect('/');
        }
        $estudiantes = Estudiantes::search($this->buscar)->orderBy('name', 'ASC')
        ->paginate($this->cantidad_registros);
        return view('livewire.seguridad.estudiantes-all-component', compact('estudiantes'))->extends('adminlte::page');
    }

    public function sendData($estudiante)
    {
        $all = true;
        $this->emit('estudianteEvent', $estudiante, $all);
    }

    public function destroy($id)
    {
        $excusa_estudiante = Excusas::where('estudiante_id', $id)->first();
        if($excusa_estudiante){
            session()->flash('warning', 'El estudiante no se puede eliminar');
            return view('livewire.estudiantes.estudiantes-component');
        }
            $estudiante = Estudiantes::find($id);
            $estudiante->delete();
            session()->flash('delete', 'Estudiante  eliminado exitosamente!');
            return view('livewire.estudiantes.estudiantes-component');

    }


}
