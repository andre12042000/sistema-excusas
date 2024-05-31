@section('title', 'Excusas')
<div class="py-5">
    @include('includes.alertas')
    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="myAlert" style="display: none;">
        En el momento no se pueden generar excusas recuerda que el horario establecido es <strong>7:00 AM - 8:00
            AM</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="card  card-success mt-2">
        <div class="card-header ">

            <div class="row">
                <div class="col-sm-6">
                    <h3>Excusas</h3>
                </div>


                <div class="col-sm-6">
                    <div class="input-group float-right">
                        <select wire:model="cantidad_registros" class="form-select col-sm-2 mr-2"
                            aria-label="Default select example">
                            <option value="10">10</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Buscar excusa" aria-label="Username"
                            aria-describedby="basic-addon1" wire:model="buscar">

                        <button type="button" id="miBoton" class="btn btn-outline-light float-right ml-2 mt-1"
                            data-toggle="modal" data-target="#excusaModal">Nueva excusa <i
                                class="las la-plus-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Grado</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($excusas as $excusa)
                            <tr>
                                <td>{{ $excusa->created_at->diffForHumans() }}</td>
                                <td>{{ ucwords($excusa->estudiante->name) }}</td>
                                <td>{{ $excusa->estudiante->grado }}</td>
                                <td>
                                    @if ($excusa->status == 'APROVADO')
                                        <span class="badge bg-success">Aprobado</span>
                                    @elseif($excusa->status == 'RECHAZADO')
                                        <span class="badge bg-danger">Rechazado</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Registrado</span>
                                    @endif
                                </td>
                                <td class="text-center">

                                    <button class="btn btn-outline-success btn-sm" type="button" data-toggle="modal"
                                        data-target="#excusaModal" wire:click="Data( {{ $excusa }} )"><i
                                            class="bi bi-eye"></i></button>

                                    <button class="btn btn-outline-danger btn-sm"
                                        @if ($excusa->status == 'APROVADO') disabled @endif
                                        wire:click="destroy( {{ $excusa->id }} )"><i
                                            class="bi bi-trash3"></i></button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5">
                                    <p>No se encontraron registros...</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
        <div class="card-footer">
            <nav aria-label="...">
                <ul class="pagination">
                    {{ $excusas->links() }}
                </ul>
            </nav>

        </div>
        <!-- Modal para crear estudiantes -->

    </div>
</div>


@include('modals.excusa.createexcusa')

<script>
    function habilitarBotonEnHorario() {
        var ahora = new Date();
        var horaActual = ahora.getHours();
        var minutoActual = ahora.getMinutes();

        var horaInicio = 7;
        var minutoInicio = 30;
        var horaFin = 16;
        var minutoFin = 30;

        var rolUsuario = "{{ $rol_user }}";
        var permiso_tarde = "{{$permiso_tarde}}";

        if (
            (rolUsuario === "Coordinador" && horaActual >= horaInicio && horaActual <= horaFin &&
            (horaActual !== horaInicio || minutoActual >= minutoInicio) &&
            (horaActual !== horaFin || minutoActual <= minutoFin))
            ||
            (permiso_tarde > 0 && horaActual >= horaInicio && horaActual <= horaFin &&
            (horaActual !== horaInicio || minutoActual >= minutoInicio) &&
            (horaActual !== horaFin || minutoActual <= minutoFin))
        ) {
            document.getElementById("miBoton").disabled = false;
        } else {
            document.getElementById("miBoton").disabled = true;
            document.getElementById("myAlert").style.display = "block";
        }
    }

    habilitarBotonEnHorario();
    setInterval(habilitarBotonEnHorario, 60000);
</script>
