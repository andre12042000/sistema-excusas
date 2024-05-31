
@extends('adminlte::page')

@section('title', 'Importador Estudiantes')

@section('content_header')

@stop

@section('content')

<div class="py-5">
@include('includes.alertas')

<div class="card ">
    <div class="card-header bg-secondary">
      <h2>Importador De Estudiantes</h2>
    </div>
    <div class="card-body">
         <form action="{{ route('import.excel.estudiantes') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" class="form-control col-8" name="file" accept=".xlsx, .xls">
    <button type="submit" class="btn btn-success float-end">Importar Excel Estudiantes</button>
</form>
    </div>

</div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
