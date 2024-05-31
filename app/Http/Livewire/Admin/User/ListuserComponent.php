<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use App\Models\Purchase;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListuserComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $cantidad_registros = 10;
    public  $buscar, $user, $filter_estado;

    protected $listeners = ['reloadusuario'];


    public function reloadusuario()
    {
        $this->render();
    }



    public function render()
    {
        Gate::authorize('Configuración Seguridad');

        if (!Auth::user()) {
            return redirect('/');
        }
        $users = User::with('roles')
                        ->orderBy('name', 'ASC')
                        ->search($this->buscar)

                        ->paginate($this->cantidad_registros);

        return view('livewire.admin.user.list-user-component', compact('users'));
    }
    public function sendData($user)
    {
        $this->emit('userEvent', $user);
    }

    public function destroy($id)
    {

            $user = User::find($id);
            $user->delete();
            session()->flash('message', 'Usuario eliminado correctamente');

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
