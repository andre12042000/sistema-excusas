<?php

namespace App\Http\Livewire\Estudiantes;

use Livewire\Component;
use App\Models\Estudiantes;
use Illuminate\Support\Facades\Auth;

class CreateComponent extends Component
{
    public $name, $codigo, $grado, $padre_id, $selected_id, $numero, $letra, $ruta;
    public $tecnica = 'NO';
    public $showmodal = 0;
    public $statusadministracion = 0;

    protected $listeners = ['estudianteEvent'];

    public function estudianteEvent($estudiante, $all)
    {
        if($all == true){
            $this->statusadministracion = 1;
        }
        $this->showmodal = 1;
        $this->selected_id  = $estudiante['id'];
        $this->name         = $estudiante['name'];
        $this->codigo       = $estudiante['codigo'];
        $this->grado        = $estudiante['grado'];
        $this->tecnica      = $estudiante['tecnica'];
        $this->ruta         = $estudiante['ruta'];
        $this->numero       = intval($this->grado); // Convertir la parte numérica a entero
        $this->letra        = substr($this->grado, -1);
    }

    protected $rules = [
        'name'       =>  'required|min:4|max:254',
        'codigo'     =>  'required|min:4|max:254|unique:estudiantes,codigo',
        'tecnica'    =>  'required',
        'ruta'       =>  'required',
        'numero'     =>  'required|numeric|between:0,11',
        'letra'      =>  'required|min:1|max:1',
    ];

    protected $messages = [
        'name.required'   => 'Este campo es requerido',
        'name.min'        => 'Este campo requiere al menos 4 caracteres',
        'name.max'        => 'Este campo no puede superar los 254 caracteres',
        'codigo.required' => 'Este campo es requerido',
        'ruta.required'   => 'Este campo es requerido',
        'codigo.min'      => 'Este campo requiere al menos 4 caracteres',
        'codigo.max'      => 'Este campo no puede superar los 254 caracteres',
        'codigo.unique'   => 'Este codigo ya ha sido registrado',
        'tecnica.required'=> 'Este campo es requerido',
        'numero.required' => 'Este campo es requerido',

        'letra.required'  => 'Este campo es requerido',
        'letra.min'       => 'Este campo requiere al menos 1 caracteres',
        'letra.max'       => 'Este campo no puede superar los 1 caracteres',
    ];
    public function render()
    {
        if (!Auth::user()) {
            return redirect('/');
        }
        return view('livewire.estudiantes.create-component');
    }



    public function storeOrupdate()
    {
        if($this->selected_id > 0){
            $this->update();
        }else{
            $this->save();
        }
        $this->emit('reloadestudiantes');
    }

    public function save()
    {
        $validatedData = $this->validate();

        if($this->numero >= 0 && $this->letra){
            $this->grado = $this->numero . strtoupper($this->letra);

        }



        $estudiante = Estudiantes::create([
            'name'      => strtoupper($this->name),
            'codigo'    => $this->codigo,
            'grado'     => $this->grado,
            'tecnica'   => $this->tecnica,
            'ruta'      => $this->ruta,
            'padre_id'  => Auth::user()->id,
        ]);
        session()->flash('message', 'Estudiante registrado exitosamente!');
        $this->cancel();


    }

    public function update()
    {
        $this->validate([
            'name'       =>  'required|min:4|max:254',
            'codigo'     =>  'required|min:4|max:254|unique:estudiantes,codigo,' . $this->selected_id,
            'tecnica'    =>  'required',
            'ruta'       =>  'required',
            'numero'     =>  'required||numeric|between:0,11',
            'letra'      =>  'required|min:1|max:1',

        ],[
            'name.required'   => 'Este campo es requerido',
            'name.min'        => 'Este campo requiere al menos 4 caracteres',
            'name.max'        => 'Este campo no puede superar los 254 caracteres',
            'codigo.required' => 'Este campo es requerido',
            'ruta.required' => 'Este campo es requerido',
            'codigo.min'      => 'Este campo requiere al menos 4 caracteres',
            'codigo.max'      => 'Este campo no puede superar los 254 caracteres',
            'codigo.unique'   => 'Este codigo ya ha sido registrado',
            'tecnica.required'=> 'Este campo es requerido',
            'numero.required' => 'Este campo es requerido',

            'letra.required'  => 'Este campo es requerido',
            'letra.min'       => 'Este campo requiere al menos 1 caracteres',
            'letra.max'       => 'Este campo no puede superar los 1 caracteres',


        ]);
        if($this->numero >= 0 && $this->letra){
            $this->grado = $this->numero . strtoupper($this->letra);
        }

        $estudiante = Estudiantes::find($this->selected_id);

        $estudiante->update([
            'name'  => strtoupper($this->name),
            'codigo'  => $this->codigo,
            'grado'  => $this->grado,
            'tecnica'  => $this->tecnica,
            'padre_id'  => Auth::user()->id,
            'ruta'      => $this->ruta,
        ]);

        $this->dispatchBrowserEvent('close-modal');
        session()->flash('message', 'Estudiante actualizado exitosamente');
    }

    public function cancel()
    {
            $this->reset();
            $this->resetErrorBag();
    }
}
