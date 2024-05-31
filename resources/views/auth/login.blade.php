@extends('layouts.app')

@section('content')
    <div class="container-xl float-center" style="background-color: rgba(0, 0, 0, 0.5); border-radius: 5px; ">
        <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >

        <div class="main-div">
            <div class="panel">
                <h2 class="text-success"> <strong>INICIAR SESIÓN</strong></h2>
                <p class="text-white"> <strong>Ingrese su usuario y contraseña</strong> </p>
            </div>

            <form method="POST" action="{{ route('login') }}" id="Login">
                @csrf

                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="Correo electrónico"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-md-12 input-group">
                        <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-light" onclick="togglePasswordVisibility('password')">
                                <i class="las la-eye-slash"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-check mt-4 mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label text-white" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>


                <button type="submit" class="btn btn-lg-success bg-success text-white" style="width: 100%">INICIAR SESIÓN</button>


                <a class="link-primary fs-7 fw-bolder" href="{{ route('password.request') }}">

                </a>


                @if (Route::has('password.request'))
                    <div class="forgot text-center mt-4">
                        <a href="{{ route('password.request') }}" class="text-white"> ¿Olvidaste la contraseña?</a>
                    </div>
                @endif


            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(fieldId) {
            var passwordField = document.getElementById(fieldId);
            var fieldType = passwordField.type;

            // Cambia el tipo de campo de contraseña a texto o viceversa
            passwordField.type = (fieldType === 'password') ? 'text' : 'password';
        }
    </script>
@endsection
