<?php

namespace App\Http\Livewire\Perfil;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\ProfesorGrados;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class UpdatePerfilComponent extends Component
{
    public $name, $direccion, $numero_identificacion, $telefono, $email, $firma, $selected_id, $photo, $url;
    use WithFileUploads;
    public $grados = ['Transición A','Transición B','1A','1B','2A','3A','3B','4A','5A','5B','6A','6B',
        '7A','7B','8A','8B','9A','9B','10A','11A',
    ];
    public $selectedGrados = [];

    public function mount(){
        $user = Auth::user();
       $this->name                  = $user->name;
       $this->direccion             = $user->direccion;
       $this->telefono              = $user->telefono;
       $this->email                 = $user->email;
       $this->numero_identificacion = $user->numero_identificacion;
       $this->photo                 = $user->firma;

       $profesorGrados = ProfesorGrados::where('profesor_id', $user->id)->pluck('grado')->toArray();

       // Asignar los grados seleccionados al componente
       $this->selectedGrados = $profesorGrados;

    }
    public function render()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        return view('livewire.perfil.update-perfil-component')->extends('adminlte::page');
    }



    public function update(){

        $this->selected_id = Auth::user()->id;

        $this->validate(
            [
                'name'                          =>  'required',
                'direccion'                     =>  'required',
                'telefono'                      =>  'required',
                'email'                         =>  'required|email|unique:users,email,' . $this->selected_id,

                'numero_identificacion'         =>  'required|unique:users,numero_identificacion,' . $this->selected_id,
            ],[
                'name.required'                     => 'Este campo es requerido',
                'direccion.required'                => 'Este campo es requerido',
                'telefono.required'                 => 'Este campo es requerido',
                'numero_identificacion.required'    => 'Este campo es requerido',
                'numero_identificacion.unique'      => 'Esta identificación ya esta en uso',
                'email.required'                    => 'Este campo es requerido',
                'email.email'                       => 'No es un formato valido de correo',
                'email.unique'                      => 'Este correo ya esta en uso',

            ],

        );

if($this->photo == ''  || $this->photo == null){
    $this->validate(
        [
            'firma'                         =>  'required|image|max:2048',
        ],[

            'firma.required'                    => 'Este campo es requerideeo',
            'firma.image'                       => 'Este campo solo recibe imagen',
            'firma.max'                         => 'El tamaño es muy grande',
            'firma.required'                    => 'Este campo es requerido',

        ],

    );
}


        $user = User::find($this->selected_id);

        $user->update([
            'name'                   => strtolower($this->name),
            'direccion'              => $this->direccion,
            'telefono'               => $this->telefono,
            'email'                  => $this->email,
            'numero_identificacion'  => $this->numero_identificacion,
        ]);
        if($this->firma)
        {

            $fileName = Str::random(40) . '.' . $this->firma->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('archivos', $this->firma, $fileName);

            $user->update([
                'firma'   =>  $fileName,
            ]);

        }
        $this->guardarGrados();
        session()->flash('message', 'Perfil actualizado exitosamente!');

    }

    public function guardarGrados()
    {
        $profesor_id = Auth::id();

        foreach ($this->selectedGrados as $grado) {
            // Verificar si ya existe una entrada para el profesor y el grado
            $existeGrado = ProfesorGrados::where('profesor_id', $profesor_id)
                ->where('grado', $grado)
                ->exists();

            if (!$existeGrado) {
                // Crear una nueva entrada solo si no existe
                ProfesorGrados::create([
                    'profesor_id' => $profesor_id,
                    'grado' => $grado,
                ]);
            }
        }
//elimina los que estan registrados pero no los seleccionaron esta vez en el arrray
        ProfesorGrados::where('profesor_id', $profesor_id)
        ->whereNotIn('grado', $this->selectedGrados)
        ->delete();

    }
}
