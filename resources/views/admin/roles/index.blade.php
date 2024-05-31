@extends('adminlte::page')

@section('scripts_head')
@include('includes.head')
@stop

@section('title', 'Roles')

@section('content_header')




@stop



@section('content')
    @include('includes.alertas')
    @livewire('admin.role.listrole-component')

<!-- Modal para crear categoría -->
@include('modals.admin.role.create')


@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
<script>
    function setFocusName() {
        $('#name').focus();
    }

    $("#rolemodal").on('shown.bs.modal', function() {
        setTimeout(setFocusName, 0);
    });
</script>

@stop
