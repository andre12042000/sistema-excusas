@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success"> <strong> {{ __('Reset Password') }}</strong></div>

                <div class="card-body text-dark">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>

                            <div class="col-md-8">
                                <input  id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-12 input-group">
                                        <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-dark" onclick="togglePasswordVisibility('password')">
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
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar </label>

                            <div class="col-md-8">
                                <div class="form-group row">
                                    <div class="col-md-12 input-group">
                                        <input id="password-confirm" type="password" placeholder=" Confirmar Contraseña" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="off">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-dark" onclick="togglePasswordVisibility('password-confirm')">
                                                <i class="las la-eye-slash"></i>
                                            </button>
                                        </div>
                                        @error('password-confirm')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                   Restablecer Contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
