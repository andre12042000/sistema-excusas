<?php

namespace App\Http\Livewire\Admin\User;

use Exception;
use App\Models\User;
use Livewire\Component;
use GuzzleHttp\Psr7\Request;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateuserComponent extends Component
{

    public $number_document, $name, $photo, $email, $selected_id, $image, $telefono, $direccion, $numero_identificacion;

    use WithFileUploads;
    public $rol_usuario = [];

    protected $listeners = ['userEvent'];

    public function userEvent($user)
    {
        $this->rol_usuario = [];
        $this->selected_id             = $user['id'];
        $this->name                    = $user['name'];
        $this->telefono                = $user['telefono'];
        $this->email                   = $user['email'];
        $this->image                   = $user['firma'];
        $this->direccion               = $user['direccion'];
        $this->numero_identificacion   = $user['numero_identificacion'];

        if (count($user['roles']) > 0) {
            foreach ($user['roles'] as $rol) {
                $this->rol_usuario[] = +$rol['id'];
            }
        }
    }
    protected $rules = [
        'name'          => 'required|min:4|max:254|unique:users,name',
        'email'         => 'required|string|email|max:255|unique:users,email',
        'photo'         => 'nullable|mimes:jpg,jpeg,bmp,png',
        'rol_usuario'   => 'required|array|min:1',
    ];

    protected $messages = [
        'name.required'     => 'El campo nombre es requerido',
        'name.min'          => 'El campo nombre debe tener al menos 6 caracteres',
        'name.max'          => 'El campo nombre no puede superar los 254 caracteres',
        'name.unique'       => 'El campo nombre ya se encuentra registrado',
        'email.max:'        => 'El campo email no puede tener mas de 255 caracteres',
        'email.email:'      => 'El campo correo electrónico no es una dirección válida',
        'email.unique'      => 'Este correo ya se encuentra registrado',
        'photo.mimes'       => 'El formato de imagen no es valido',
    ];
    public function render()
    {
        Gate::authorize('Configuración Seguridad');

        if (!Auth::user()) {
            return redirect('/');
        }
        $roles = Role::all();

        return view('livewire.admin.user.create-user-component', compact('roles'));
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validatedData = $this->validate();
        try {



            if(!empty($this->photo))
            {


                $fileName = Str::random(40) . '.' . $this->photo->getClientOriginalExtension();

                Storage::disk('public')->putFileAs('archivos', $this->photo, $fileName);

              $firma = $fileName;


            }else{

                $firma = null;
            }

            $user = User::create([
                'name'                      => strtolower($this->name),
                'telefono'                  => $this->telefono,
                'numero_identificacion'     => $this->numero_identificacion,
                'direccion'                 => $this->direccion,
                'firma'                     => $firma,
                'email'                     => $this->email,
                'password'                  => bcrypt($this->numero_identificacion),
            ]);



            $user->roles()->sync($this->rol_usuario);

            $this->cleanData();
            session()->flash('message', 'Usuario  creado exitosamente');
        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    public function cleanData()
    {
        $this->reset();
        $this->resetErrorBag();
    }



    public function storeOrupdate()
    {
        if ($this->selected_id > 0) {
            $this->update();
        } else {
            $this->save();
        }
        $this->emit('reloadusuario');
    }


    public function update()
    {
        $this->validate([
            'name'          => 'required|min:4|max:254|unique:users,name,' . $this->selected_id,
            'email'         => 'required|string|email|max:255|unique:users,email,' . $this->selected_id,
            'photo'         => 'nullable|mimes:jpg,jpeg,bmp,png',
            'rol_usuario'   => 'required|array|min:1',
        ]);

        $user = User::find($this->selected_id);

        $user->update([
            'name'                      => strtolower($this->name),
            'telefono'                  => $this->telefono,
            'numero_identificacion'     => $this->numero_identificacion,
            'direccion'                 => $this->direccion,
            'email'                     => $this->email,
        ]);


        $user->roles()->sync($this->rol_usuario);


        if(!empty($this->photo)){


            $fileName = Str::random(40) . '.' . $this->photo->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('archivos', $this->photo, $fileName);

            $user->update([
                'firma'   =>  $fileName,
            ]);

        }


        session()->flash('message', 'Usuario  actualizado exitosamente');
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert');
    }
}
