<?php

namespace App\Http\Livewire\Excusas;

use App\Models\Excusas;
use Livewire\Component;
use App\Models\Estudiantes;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ExcusasComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
     public $buscar;
     public $cantidad_registros = 10;
     protected $listeners = ['reloadexcusas'];
    public $autorizar = 0;

     public function reloadexcusas()
     {
         $this->render();
     }

    public function render()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
      $user = Auth::user()->id;
      if(auth()->user()->roles->contains('name', 'Coordinador')){
      $rol_user = 'Coordinador';
      }else{
        $rol_user = 'Padre';
      }

      $estudiantes = Estudiantes::where('padre_id', $user)->get();
      $permiso_tarde = 0; // Inicializa la variable $permiso_tarde en 0

      foreach ($estudiantes as $estudiante) {
          $grado = $estudiante->grado; // Obtén el grado del estudiante
          // Separa los números de las letras en el grado (por ejemplo, '10A' se convierte en ['10', 'A'])
          $gradoSeparado = preg_split("/([0-9]+)/", $grado, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
          // Si el gradoSeparado contiene al menos dos elementos (números y letras), verifica si el número es mayor a 9
          if (count($gradoSeparado) >= 2 && (int)$gradoSeparado[0] > 9) {

              $permiso_tarde += 1; // Incrementa $permiso_tarde si el número es mayor a 9

          }
      }


        $excusas = Excusas::where('padre_id', $user)->search($this->buscar)->orderBy('created_at', 'desc')
        ->paginate($this->cantidad_registros);
        return view('livewire.excusas.excusas-component', compact('excusas', 'rol_user', 'permiso_tarde'))->extends('adminlte::page');
    }

    public function Data($excusa)
    {

        $this->emit('excusaEvent', $excusa);
    }

    public function destroy($id)
    {
            $excusas = Excusas::find($id);
            $excusas->delete();
            session()->flash('message', 'Excusa eliminada exitosamente!');
            return view('livewire.excusas.excusas-component');


    }

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

    public function autorizar(){
        $this->autorizar = 1;
        $user = Auth::user()->id;

        $excusas = Excusas::search($this->buscar)->orderBy('created_at', 'desc')
        ->paginate($this->cantidad_registros);
        return view('livewire.excusas.autorizacion-excusa', compact('excusas'));
    }


}
