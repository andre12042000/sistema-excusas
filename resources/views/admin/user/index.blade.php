@extends('adminlte::page')

@section('scripts_head')
@include('includes.head')
@stop

@section('title', 'Usuarios')

@section('content_header')



@stop



@section('content')

@livewire('admin.user.listuser-component')

<!-- Modal para crear categoría -->
@include('modals.admin.user.create')


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
<script>
    function setFocusName()
        {
            $('#name').focus();
        }

        $("#usuariomodal").on('shown.bs.modal', function()
        {
            setTimeout(setFocusName, 0);
        });
</script>

@stop
