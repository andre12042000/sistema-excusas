<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="img/logo.png" rel="icon">
    <link href="{!! Config::get('app.URL') !!}/assets/img/logo.png" rel="icon">
    <title>Iniciar Sesión</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }




        .fondo {
            background-image: url('img/fondo.jpeg');
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            color: #000;
        }

        .login-form {
            margin-top: 10%;

        }


        .form-heading {
            color: #fff;
            font-size: 23px;
        }

        .panel h2 {
            color: #444444;
            font-size: 18px;
            margin: 0 0 8px 0;
        }

        .panel p {
            color: #777777;
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 24px;
        }

        .login-form .form-control {
            background: #f7f7f7 none repeat scroll 0 0;
            border: 1px solid #d4d4d4;
            border-radius: 4px;
            font-size: 14px;
            height: 50px;
            line-height: 50px;
        }

        .main-div {
            background: transparent none repeat scroll 0 0;
            border-radius: 2px;
            margin: 10px auto 10px;
            max-width: 100%;
            padding: 30px 70px 5px 71px;
        }

        .login-form .form-group {
            margin-bottom: 10px;
        }

        .login-form {
            text-align: center;
        }

        .forgot a {
            color: #777777;
            font-size: 14px;
            text-decoration: underline;
        }

        .login-form .btn.btn-primary {
            background: #f0ad4e none repeat scroll 0 0;
            border-color: #f0ad4e;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0;
        }

        .forgot {
            text-align: left;
            margin-bottom: 30px;
        }

        .botto-text {
            color: #ffffff;
            font-size: 14px;
            margin: auto;
        }

        .login-form .btn.btn-primary.reset {
            background: #ff9900 none repeat scroll 0 0;
        }

        .back {
            text-align: left;
            margin-top: 10px;
        }

        .back a {
            color: #444444;
            font-size: 13px;
            text-decoration: none;
        }

        /*----------------------------------------------------------------------------*/

        .main-head {
            height: 150px;
            background: #FFF;

        }






        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }
        }

        @media screen and (max-width: 450px) {
            .login-form {
                margin-top: 10%;
            }

            .register-form {
                margin-top: 10%;
            }
        }

        @media screen and (min-width: 768px) {
            .main {
                margin-left: 23%;
            }

            .sidenav {
                width: 40%;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;

            }

            .login-form {
                margin-top: 0%;
            }

            .register-form {
                margin-top: 20%;
            }
        }

        .my-5.display-4.fw-bold.ls-tight {
            font-family: "Roboto Slab", sans-serif;
            font-weight: bold;
            font-size: 50px;
        }


    </style>
</head>

<body class="fondo" style="color: white; background-color: rgba(11, 47, 18, 0.5);" style="background-color: #033468 ;">
    <div class=" text-center">
        <h3 class="my-3 ml-5  fw-bold ls-tight ">
            Bienvenidos Padres De Familia y/o Acudientes de la Institución Educativa El Cusiana  <br/>
        </h3>

</div>
    <div class="row" style="width: 99%">
        <div class="col-md-6">
            <div class=" text-right">
                <h2 class="my-5 ml-5  bold fw-bold ls-tight ">
                   <br />

                </h2>

        </div>
        </div>

        <div class="col-md-5">
            <div class=" container main">
                <div class="login-form">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
