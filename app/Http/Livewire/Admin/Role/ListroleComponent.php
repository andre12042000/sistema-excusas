<?php

namespace App\Http\Livewire\Admin\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListroleComponent extends Component
{
    protected $listeners = ['reloadrol'];
    public $rol;

    public function reloadrol()
    {
        $this->rol = Role::all();
    }
    public function render()
    {
        Gate::authorize('Configuración Seguridad');
        if (!Auth::user()) {
            return redirect('/');
        }
        $roles = Role::with('permissions')->get();

        return view('livewire.admin.role.list-role-component', compact('roles'));
    }

    public function sendData($rol)
    {
        $this->emit('roleEvent', $rol);
    }

    public function destroy($id)
    {

        $rol = Role::find($id);
            $rol->delete();
            session()->flash('delete', 'Rol  eliminado exitosamente');
    }
}
