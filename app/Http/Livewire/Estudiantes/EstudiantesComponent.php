<?php

namespace App\Http\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Estudiantes;
use App\Models\Excusas;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class EstudiantesComponent extends Component
{
    use WithPagination;
    public $cantidad_registros = 10;
    protected $paginationTheme = 'bootstrap';
    public $buscar;

    protected $listeners = ['reloadestudiantes'];


    public function reloadestudiantes()
    {
        $this->render();
    }
    public function render()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        $user = Auth::user()->id;

        $estudiantes = Estudiantes::where('padre_id', $user)->search($this->buscar)->orderBy('name', 'ASC')
        ->paginate($this->cantidad_registros);


        return view('livewire.estudiantes.estudiantes-component', compact('estudiantes'))->extends('adminlte::page');
    }

    public function sendData($estudiante)
    {
        $all = false;
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


    //Metodos necesarios para la usabilidad


    public function updatingSearch(): void
    {
        $this->gotoPage(1);
    }


    public function doAction($action)
    {
        $this->resetInput();
    }

    //método para reiniciar variables
    private function resetInput()
    {
        $this->reset();
    }

}
