@section('title', 'Notificaciones')


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">
@stop

@section('content_header')


@stop

@section('content')




    <div>
        <div>



        <div class="card mt-2">
            <div class="card-header bg-info">
                <div class="row">
                    <div class="col-sm-8">
                        <h3>Notificaciones</h3>
                    </div>
                   {{--  <div class="col-sm-1">
                        <div class="input-group float-right">
                            <select wire:model="cantidad_registros" class="form-select col-sm-12 mr-2"
                                aria-label="Default select example">
                                <option value="10"> 5 </option>
                                <option value="30">10</option>
                                <option value="30">15</option>
                                <option value="30">20</option>

                            </select>
                        </div>
                    </div> --}}
                    <div class="col-sm-4"> <a class=" btn btn-outline-light"
                            href="{{ route('markAsRead') }}" id="mark-all"><strong><i class="bi bi-card-checklist"></i> Marcar
                                todas como leídas</strong></a>
                    </div>


                </div>
            </div>
            <div class="card-body">

                <table class="table table-striped" id="tabClientes">
                    <thead>
                        <tr>

                            <th>Orden</th>
                            <th>Hora</th>
                            <th>Mensaje</th>
                            <th>Alumno</th>
                            <th>Grado</th>
                            <th>Observaciones</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notifications as $notificacion)
                            <tr>
                                <td> {{ $loop->iteration }} </td>

                                <td>{{ $notificacion['created_at']->diffForHumans() }}</td>
                                <td>{{ $notificacion['data']['message'] }}</td>
                                <td>{{ $notificacion['data']['alumno'] }}</td>
                                <td>{{ $notificacion['data']['grado'] }}</td>
                                <td>@isset ($notificacion['data']['observaciones'])
                                    {{ $notificacion['data']['observaciones'] }}</td>
@else
No hay ninguna observación
                                @endisset
                                <td class="text-center">
                                    <button type="submit" class="mark-as-read btn btn-outline-success btn-sm"
                                        data-id="{{ $notificacion['id'] }}" wire:click="marcar_leida">Marcar como
                                        leída</button>
                                    {{-- <a @popper(Marcar como leída ) class="btn btn-outline-success btn-sm"
                                wire:click="marcar_leida({{ $notificacion['id'] }})" role="button"><i
                                    class="las la-check-double"></i></a> --}}

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="2">
                                    <p>No se encontraron registros...</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer ">
                <nav class="" aria-label="">
                    <ul class="pagination">

                    </ul>
                </nav>

            </div>
        </div>
    </div>

@stop
@section('js')
    <script>
        console.log('Hi!');
    </script>
    <script>
        function sendMarkRequest(id = null) {
            return $.ajax("{{ route('markNotification') }}", {
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id
                }
            });
        }
        $(function() {
            $('.mark-as-read').click(function() {
                let button = $(this);
                let request = sendMarkRequest(button.data('id'));
                request.done(() => {
                    button.parents('div.alert').remove();
                    // Recargar la página después de marcar como leída
                    location.reload();
                });
            });
            $('#mark-all').click(function() {
                let request = sendMarkRequest();
                request.done(() => {
                    $('div.alert').remove();
                })
            });
        });
    </script>

@stop
