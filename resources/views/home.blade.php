@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="row py-5">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6">
        <div class="card text-center card-warning">
            <div class="card-header">
                <i class="fas fa-exclamation-triangle mr-2"></i> <strong> Advertencia </strong>  <i class="fas fa-exclamation-triangle ml-2"></i>
            </div>
            <div class="card-body">
              <h3 class="">HORARIO DE SOLICITUD O RADICACIÓN DE EXCUSAS</h3>
              <h4>Sede Bachiller</h4>
              <p class="card-text"><strong>LUNES A VIERNES</strong></p>
             <strong>6:00 AM - 8:30 AM</strong>
            </div>
          </div>
    </div>
    <div class="col-sm-3">
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
