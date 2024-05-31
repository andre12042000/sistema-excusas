
@extends('layouts.app')

@section('content')
    <div class="container-xll float-center" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 5px; ">


        <div class="main-div">
            <div class="panel">
                <h2 class="text-success"> <strong>Restaurar tu contraseña</strong></h2>

            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                    <label for="email" class="col-form-label text-md-end">Correo Electrónico</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingresa tu correo registrado en el sistema">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    <div class="p-5">
                        <button type="submit" class="btn btn-success btn-lg">
                           Enviar enlace de restauración
                        </button>
                    </div>

            </form>



        </div>
    </div>

@endsection
