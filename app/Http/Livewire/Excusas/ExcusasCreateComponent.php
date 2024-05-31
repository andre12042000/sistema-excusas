<?php

namespace App\Http\Livewire\Excusas;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Excusas;
use Livewire\Component;
use App\Models\Estudiantes;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ProfesorGrados;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use App\Notifications\ExcusaAprovadaNotificacion;
use App\Notifications\ExcusaRechazadoNotificacion;
use App\Notifications\CoordinadorNuevaExcusaNotificacion;

class ExcusasCreateComponent extends Component
{
    public $observaciones, $observaciones2,  $fecha_hoy, $estudiante_id, $padre_id, $grado, $status, $tecnica, $motivo, $fecha_final, $fecha_inicial,   $fecha_radicado, $selected_id, $documento;
    protected $listeners = ['excusaEvent'];
    public $mostrarobservvacion = 0;
    public $firma_coordinador = 'null';
    public $documentocon = null;
    public $telefono, $codigo;
    public $tipo = 'EXCUSA';
    public $dias = 0;
    public $horas = 1;

    public $hora_exacta = '';
    public $motivo_descripcion, $correo;
    public $primera_hora, $segunda_hora, $tercera_hora, $cuarta_hora, $quinta_hora, $sexta_hora, $septima_hora, $numero, $ruta;


    use WithFileUploads;

    public $show = 0;
    public function excusaEvent($excusa)
    {


        $this->tipo                 = $excusa['tipo'];
        $this->motivo_descripcion   = $excusa['motivo_descripcion'];

        $this->hora_exacta          = $excusa['hora_exacta'];
        $this->codigo               = $excusa['codigo'];
        $this->primera_hora         = $excusa['primera_hora'];
        $this->segunda_hora         = $excusa['segunda_hora'];
        $this->tercera_hora         = $excusa['tercera_hora'];
        $this->cuarta_hora          = $excusa['cuarta_hora'];
        $this->quinta_hora          = $excusa['quinta_hora'];
        $this->sexta_hora           = $excusa['sexta_hora'];
        $this->septima_hora         = $excusa['septima_hora'];
        $this->selected_id          = $excusa['id'];
        $this->grado                = $excusa['grado'];
        $this->estudiante_id        = $excusa['estudiante_id'];
        $this->tecnica              = $excusa['tecnica'];
        $this->horas                = $excusa['horas'];
        $this->motivo               = $excusa['motivo'];
        $this->telefono             = $excusa['telefono'];
        $this->documento            = $excusa['soporte_excusa'];
        $this->documentocon         = $excusa['soporte_excusa'];
        $this->observaciones        = $excusa['observaciones'];
        $this->observaciones2       = $excusa['observaciones'];
        $padre_id                   =  $excusa['padre_id'];
        $this->status               = $excusa['status'];
        $this->padre_id             = User::find($padre_id);
        $this->fecha_radicado       = Carbon::parse($excusa['created_at'])->subDay();
        $this->fecha_inicial        = $excusa['fecha_inicial'];
        $this->fecha_final          = $excusa['fecha_final'];

        $fecha1 = Carbon::parse($this->fecha_inicial);
        $fecha2 = Carbon::parse($this->fecha_final);


        $this->dias = $fecha1->diffInDays($fecha2);

        $this->show          = 1;
        $this->firma_coordinador = $excusa['firma'];

        $estudiantes = Estudiantes::where('id', $this->estudiante_id)->first();
        $this->ruta = $estudiantes->ruta;
    }
    protected $rules = [
        'estudiante_id'       =>  'required',
        'grado'               =>  'required',
        'tecnica'             =>  'required',
        'telefono'            =>  'required|min:10|max:10',
        'motivo'              =>  'required',
        'tipo'                =>  'required',
    ];

    protected $messages = [
        'estudiante_id.required'   => 'Este campo es requerido',
        'grado.required'           => 'Este campo es requerido',
        'tecnica.required'         => 'Este campo es requerido',
        'motivo.required'           => 'Este campo es requerido',
    ];



    public function render()
    {
        if ($this->hora_exacta == '') {
            $this->hora_exacta = Carbon::now()->format('H:i');
        }
        $hoy = Carbon::now();
        $hoy = $hoy->format('Y-m-d');
        $this->fecha_hoy = $hoy;

        $firma = Auth::user()->firma;
        $user = Auth::user()->id;
        $padre = User::find($user);
        if ($this->codigo == '') {
            $ultimoCodigo = Excusas::latest('id')->value('codigo');
            $nuevoNumero = $ultimoCodigo ? intval(substr($ultimoCodigo, 4)) + 1 : 1;
            $this->codigo = 'EXC-' . str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
        }

        $horaActual = Carbon::now()->format('H:i');

        // Definir la hora límite para la condición (8:30)
        $horaLimite = Carbon::createFromFormat('H:i', '08:30');
        $horaTecnic = Carbon::createFromFormat('H:i', '14:00');


        // Verificar la condición
        if (Carbon::now()->greaterThanOrEqualTo($horaLimite)) {
            $this->tipo = 'SALIDA';
            $bloque_hora = 1;
        } else {
            $this->tipo = 'EXCUSA';
            $bloque_hora = 0;
        }



        //verificar si tiene hijos en 10 0 11 y en tecnica
        $studi = Estudiantes::where('padre_id', $user)->get();
        $permiso_tarde = 0; // Inicializa la variable $permiso_tarde en 0

        foreach ($studi as $estudiante) {
            $grado = $estudiante->grado; // Obtén el grado del estudiante
            // Separa los números de las letras en el grado (por ejemplo, '10A' se convierte en ['10', 'A'])
            $gradoSeparado = preg_split("/([0-9]+)/", $grado, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
            // Si el gradoSeparado contiene al menos dos elementos (números y letras), verifica si el número es mayor a 9
            if (count($gradoSeparado) >= 2 && (int)$gradoSeparado[0] > 9) {

                $permiso_tarde += 1; // Incrementa $permiso_tarde si el número es mayor a 9

            }
        }

        if(auth()->user()->roles->contains('name', 'Coordinador')){

            if( $bloque_hora > 0 ){
                $estudiantes = Estudiantes::orderBy('name', 'ASC')->get();
            }elseif(Carbon::now()->greaterThanOrEqualTo($horaTecnic)){
                $estudiantes = Estudiantes::where(function ($query) {
                    $query->where('grado', 'like', '1%'); // Filtrar grados de 10 y 11 (comienzan con '1')
                })->where('tecnica', 'SI')->orderBy('name', 'ASC')->get();
            }else{

                $estudiantes = Estudiantes::where('padre_id', $user)->get();
            }

            }elseif(auth()->user()->roles->contains('name', 'Padre') && $horaActual >= $horaTecnic  ){
                $estudiantes = Estudiantes::where(function ($query) {
                    $query->where('grado', 'like', '1%'); // Filtrar grados de 10 y 11 (comienzan con '1')
                })->where('padre_id', $user) // Filtrar por padre_id (suponiendo que $user es el usuario autenticado)
                ->where('tecnica', 'SI')
                ->orderBy('name', 'ASC')->get();
            }else{

                $estudiantes = Estudiantes::where('padre_id', $user)->get();
            }





        return view('livewire.excusas.excusas-create-component', compact('estudiantes', 'padre', 'firma', 'bloque_hora'));
    }

    public function updatedEstudianteId($value)
    {
        if ($value == '') {
            $this->grado = '';
            $this->tecnica = '';
            $this->ruta = '';
        } else {
            $estudiantes = Estudiantes::where('id', $value)->first();
            $this->grado = $estudiantes->grado;
            $this->ruta = $estudiantes->ruta;
            $this->tecnica = $estudiantes->tecnica;
            $this->numero       = intval($this->grado);
        }
    }
    public function updatedFechaInicial($value)
    {
        if ($this->fecha_final != '') {
            $fecha1 = Carbon::parse($value);
            $fecha2 = Carbon::parse($this->fecha_final);


            $this->dias = $fecha1->diffInDays($fecha2);
        }

        if ($this->motivo == 'UNIFORME' && $this->dias > 8) {
            session()->flash('warning', 'La excusa no puede ser superior a 8 días');
            $this->fecha_final = '';
        }
    }

    public function updatedFechaFinal($value)
    {
        if ($this->fecha_inicial != '') {
            $fecha1 = Carbon::parse($value);
            $fecha2 = Carbon::parse($this->fecha_inicial);


            $this->dias = $fecha1->diffInDays($fecha2);
        }

        if ($this->motivo == 'UNIFORME' && $this->dias > 8) {
            session()->flash('warning', 'La excusa no puede ser superior a 8 días');

            $this->fecha_final = '';
        }
    }

    public function send()
    {

        if ($this->motivo == 'OTRO') {
            $this->validate([
                'motivo_descripcion'       =>  'required',
            ]);
        }



        if ($this->fecha_final == '' || $this->fecha_final == '') {
            $this->validate([
                'horas'               =>  'required|between:1,6|max:1',
                'hora_exacta'         =>  'required'

            ]);
        } else {
            $this->horas = '';
            $this->hora_exacta = '';
        }

        if ($this->fecha_inicial != '' && $this->horas == '' && $this->hora_exacta == '') {
            $this->validate([
                'fecha_inicial'       =>  'required|date|after_or_equal:today',
                'fecha_final'         =>  'required|date|after_or_equal:fecha_inicial',

            ]);
        }
        if ($this->motivo == 'UNIFORME' && $this->dias > 8) {
            session()->flash('warning', 'La excusa no puede ser superior a 8 días');
            $this->fecha_final = '';
        }
        $validatedData = $this->validate();
        $excusa = Excusas::create([
            'estudiante_id'         => $this->estudiante_id,
            'motivo'                => $this->motivo,
            'telefono'              => $this->telefono,
            'grado'                 => $this->grado,
            'padre_id'              => Auth::user()->id,
            'fecha_final'           => $this->fecha_final,
            'fecha_inicial'         => $this->fecha_inicial,
            'horas'                 => $this->horas,
            'status'                => 'REGISTRADO',
            'firma'                 => 'null',
            'soporte_excusa'        => null,
            'hora_exacta'           => $this->hora_exacta,
            'tipo'                  => $this->tipo,
            'motivo_descripcion'    => $this->motivo_descripcion,
            'primera_hora'          => $this->primera_hora,
            'segunda_hora'          => $this->segunda_hora,
            'tercera_hora'          => $this->tercera_hora,
            'cuarta_hora'           => $this->cuarta_hora,
            'quinta_hora'           => $this->quinta_hora,
            'sexta_hora'            => $this->sexta_hora,
            'septima_hora'          => $this->septima_hora,


        ]);
        if ($this->documento) {
            $fileName = Str::random(40) . '.' . $this->documento->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('archivos', $this->documento, $fileName);
            $excusa->update([
                'soporte_excusa' => $fileName,
            ]);
        }

        $this->notificacionesCoordinador($excusa);

        $this->documento = '';
        $this->cancel();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert');
        $this->emit('reloadexcusas');
    }

    function notificacionesCoordinador($excusa)
    {
        $role = Role::where('name', 'Coordinador')->first();
        $usersWithPermission = $role->users;

        foreach ($usersWithPermission as $user) {
            $user->notify(new CoordinadorNuevaExcusaNotificacion($excusa));
        }
    }

    public function autorizacion($id)
    {
        $autorizacion = Excusas::find($id);
        $correo_motivo = '';
        $autorizacion->update([
            'firma'          => Auth::user()->firma,
            'status'  => 'APROVADO',
        ]);
        $this->notificacionesPadre($autorizacion);
        $this->notificacionesProfesor($autorizacion);
        $this->emit('autorizacion');
        $this->dispatchBrowserEvent('close-modal');
        $tipo_correo = 'APROVADO';
        $this->EnviarCorreoEvent($tipo_correo, $correo_motivo);
        session()->flash('message', 'Excusa aprovada exitosamente!');
        $this->dispatchBrowserEvent('alert-aprovada');

    }


    function notificacionesProfesor($excusa)
    {
        // Obtener el grado de la excusa
        $gradoExcusa = $excusa->grado;

        // Buscar todos los profesores que enseñan este grado
        $profesores = ProfesorGrados::where('grado', $gradoExcusa)->get();

        // Enviar la notificación a cada profesor encontrado
        foreach ($profesores as $profesor) {
            $profesor->users->notify(new ExcusaAprovadaNotificacion($excusa));
        }

    }

    function notificacionesPadre($excusa)
    {

        $user = User::find($excusa->padre_id);

        $user->notify(new ExcusaAprovadaNotificacion($excusa));

        /*  User::role(['Coordinador'])->except($excusa->padre_id)
        ->each(function(User $user) use ($excusa){
             $user->notify(new CoordinadorNuevaExcusaNotificacion($excusa));
        }); */
    }

    public function rechazado($id)
    {

        $this->mostrarobservvacion = 1;

        $this->validate(
            [
                'observaciones'                          =>  'required',

            ],
            [
                'observaciones.required'                     => 'Este campo es requerido',
            ],

        );

        $autorizacion = Excusas::find($id);
        $correo_motivo = $this->observaciones;
        $autorizacion->update([
            'firma'          => Auth::user()->firma,
            'status'  => 'RECHAZADO',
            'observaciones'  => $this->observaciones,
        ]);
        $this->notificacionesPadreRechazado($autorizacion);
        $this->emit('autorizacion');
        $this->dispatchBrowserEvent('close-modal');
        $tipo_correo = 'RECHAZADO';
        $this->EnviarCorreoEvent($tipo_correo, $correo_motivo);
        $this->dispatchBrowserEvent('alert-rechazada');
    }

    function notificacionesPadreRechazado($excusa)
    {

        $user = User::find($excusa->padre_id);

        $user->notify(new ExcusaRechazadoNotificacion($excusa));

        /*  User::role(['Coordinador'])->except($excusa->padre_id)
        ->each(function(User $user) use ($excusa){
             $user->notify(new CoordinadorNuevaExcusaNotificacion($excusa));
        }); */
    }

    public function cancel()
    {
        $this->reset();
        $this->resetErrorBag();
    }

    function EnviarCorreoEvent($tipo, $correo_motivo)
    {
        $this->correo = Auth::user()->email;


        if ($tipo == 'APROVADO') {
            $mensaje = 'Su excusa fue aprovada por el coordinador';
            $subjet = 'Excusa Aprovada';
            Mail::raw($mensaje, function ($message) use ($subjet) {
                $message->to($this->correo)
                    ->subject($subjet)
                    ->text('Content-Type', 'image/svg+xml');
            });
        } elseif ($tipo == 'RECHAZADO') {
            $mensaje = 'Su excusa fue rechazada por el coordinador, Comunicate con el coordinador. Motivo: ' . $correo_motivo;
            $subjet = 'Excusa Rechazada';

            Mail::raw($mensaje, function ($message) use ($subjet) {
                $message->to($this->correo)
                    ->subject($subjet)
                    ->text('Content-Type', 'image/svg+xml');
            });
        } else {
            $mensaje = 'Se detecto un ingreso al sistema de excusas, si no eres tu comunicate con el coordinador!';
            $subjet = 'Ingreso detectado';

            Mail::raw($mensaje, function ($message) use ($subjet) {
                $message->to($this->correo)
                    ->subject($subjet)
                    ->text('Content-Type', 'image/svg+xml');
            });
        }
    }

    public function updatedHoraExacta($value)
    {
        $this->primera_hora = null;
        $this->segunda_hora = null;
        $this->tercera_hora = null;
        $this->cuarta_hora = null;
        $this->quinta_hora = null;
        $this->sexta_hora = null;
        $this->septima_hora = null;

        $hora = \DateTime::createFromFormat('H:i', $value);
        if ($this->horas > 0) {
            $horaestable = $this->horas;
            $horaExacta = \DateTime::createFromFormat('H:i', $value);
            $horaFin = $horaExacta->modify("+{$horaestable} hours");

            $inicio_primera = '06:20';
            $fin_primera = '07:20';
            $inicio_segunda = '07:20';
            $fin_segunda = '08:20';

            if ($this->numero == '0') {
                $inicio_tercera = '08:50';
                $fin_tercera = '09:50';
                $inicio_cuarta = '09:50';
                $fin_cuarta = '10:50';
                $inicio_quinta = '10:50';
                $fin_quinta = '11:50';
            } elseif ($this->numero >= 1 && $this->numero < 6) {
                $inicio_tercera = '08:40';
                $fin_tercera = '09:40';
                $inicio_cuarta = '09:40';
                $fin_cuarta = '10:40';
                $inicio_quinta = '10:50';
                $fin_quinta = '11:50';
                $inicio_sexta = '11:50';
                $fin_sexta = '12:50';
            } else {
                $inicio_tercera = '08:20';
                $fin_tercera = '09:20';
                $inicio_cuarta = '09:40';
                $fin_cuarta = '10:40';
                $inicio_quinta = '10:40';
                $fin_quinta = '11:40';
                $inicio_sexta = '11:50';
                $fin_sexta = '12:50';
                $inicio_septima = '12:50';
                $fin_septima = '13:50';
            }

            $inicio_primera = \DateTime::createFromFormat('H:i', $inicio_primera);
            $fin_primera = \DateTime::createFromFormat('H:i', $fin_primera);

            $inicio_segunda = \DateTime::createFromFormat('H:i', $inicio_segunda);
            $fin_segunda = \DateTime::createFromFormat('H:i', $fin_segunda);

            $inicio_tercera = \DateTime::createFromFormat('H:i', $inicio_tercera);
            $fin_tercera = \DateTime::createFromFormat('H:i', $fin_tercera);

            $inicio_cuarta = \DateTime::createFromFormat('H:i', $inicio_cuarta);
            $fin_cuarta = \DateTime::createFromFormat('H:i', $fin_cuarta);

            $inicio_quinta = \DateTime::createFromFormat('H:i', $inicio_quinta);
            $fin_quinta = \DateTime::createFromFormat('H:i', $fin_quinta);

            if ($inicio_sexta) {
                $inicio_sexta = \DateTime::createFromFormat('H:i', $inicio_sexta);
                $fin_sexta = \DateTime::createFromFormat('H:i', $fin_sexta);

                if ($hora >= $inicio_sexta && $horaFin <= $fin_sexta ||  $hora < $inicio_sexta && $horaFin <= $fin_sexta && $horaFin > $inicio_sexta || $hora >= $inicio_sexta &&  $hora < $fin_sexta && $horaFin > $fin_sexta ||  $hora < $inicio_sexta &&  $horaFin > $fin_sexta) {
                    $this->sexta_hora = 'SI';
                }
            }
            if (isset($inicio_septima)) {
                $inicio_septima = \DateTime::createFromFormat('H:i', $inicio_septima);
                $fin_septima = \DateTime::createFromFormat('H:i', $fin_septima);
                if ($hora >= $inicio_septima && $horaFin <= $fin_septima ||  $hora < $inicio_septima && $horaFin <= $fin_septima && $horaFin > $inicio_septima || $hora >= $inicio_septima &&  $hora < $fin_septima && $horaFin > $fin_septima ||  $hora < $inicio_septima &&  $horaFin > $fin_septima) {
                    $this->septima_hora = 'SI';
                }
            }
            // Inicializar el array de superposiciones
            if ($hora >= $inicio_primera && $horaFin <= $fin_primera ||  $hora < $inicio_primera && $horaFin <= $fin_primera && $horaFin > $inicio_primera || $hora >= $inicio_primera &&  $hora < $fin_primera && $horaFin > $fin_primera) {
                $this->primera_hora = 'SI';
            }
            if ($hora >= $inicio_segunda && $horaFin <= $fin_segunda ||  $hora < $inicio_segunda && $horaFin <= $fin_segunda && $horaFin > $inicio_segunda || $hora >= $inicio_segunda &&  $hora < $fin_segunda && $horaFin > $fin_segunda ||  $hora < $inicio_segunda &&  $horaFin > $fin_segunda) {
                $this->segunda_hora = 'SI';
            }

            if ($hora >= $inicio_tercera && $horaFin <= $fin_tercera ||  $hora < $inicio_tercera && $horaFin <= $fin_tercera && $horaFin > $inicio_tercera || $hora >= $inicio_tercera &&  $hora < $fin_tercera && $horaFin > $fin_tercera ||  $hora < $inicio_tercera &&  $horaFin > $fin_tercera) {
                $this->tercera_hora = 'SI';
            }

            if ($hora >= $inicio_cuarta && $horaFin <= $fin_cuarta ||  $hora < $inicio_cuarta && $horaFin <= $fin_cuarta && $horaFin > $inicio_cuarta || $hora >= $inicio_cuarta &&  $hora < $fin_cuarta && $horaFin > $fin_cuarta ||  $hora < $inicio_cuarta &&  $horaFin > $fin_cuarta) {
                $this->cuarta_hora = 'SI';
            }
            if ($hora >= $inicio_quinta && $horaFin <= $fin_quinta ||  $hora < $inicio_quinta && $horaFin <= $fin_quinta && $horaFin > $inicio_quinta || $hora >= $inicio_quinta &&  $hora < $fin_quinta && $horaFin > $fin_quinta ||  $hora < $inicio_quinta &&  $horaFin > $fin_quinta) {
                $this->quinta_hora = 'SI';
            }
        }


        if ($this->numero == '0' || $this->numero == null) {
            $this->sexta_hora = null;
            $this->septima_hora = null;
        } elseif ($this->numero >= 1 && $this->numero < 6 || $this->numero == null) {
            $this->sexta_hora = null;
        }
    }

    public function updatedHoras()
    {
        $this->primera_hora = null;
        $this->segunda_hora = null;
        $this->tercera_hora = null;
        $this->cuarta_hora = null;
        $this->quinta_hora = null;
        $this->sexta_hora = null;
        $this->septima_hora = null;
        $this->updatedHoraExacta($this->hora_exacta);
    }
}
