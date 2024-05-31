@section('title', 'Autorización')

<div class="py-5">
    @include('includes.alertas')
    <div class="card mt-2">
        <div class="card-header bg-success">
            <div class="row">
                <div class="col-md-6">
                    <h3>Autorización Excusas</h3>
                </div>
                <div class="col-md-6">
                    <div class="input-group float-md-right">
                        <!-- Tus selects y barra de búsqueda aquí -->
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
                                @if($excusa->status == 'APROVADO')
                                <span class="badge bg-success">Aprobado</span>
                                @elseif($excusa->status == 'RECHAZADO')
                                <span class="badge bg-danger">Rechazado</span>
                                @else
                                <span class="badge bg-warning text-dark">Registrado</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-success btn-sm" type="button"
                                    data-toggle="modal" data-target="#excusaModal"
                                    wire:click="autorizaciondatos( {{ $excusa }} )"><i class="bi bi-eye"></i>
                                </button>
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
                <ul class="pagination justify-content-end">
                    {{ $excusas->links() }}
                </ul>
            </nav>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        window.addEventListener('alert-aprovada', event => {

               Swal.fire(
                   'Excusa aprovada correctamente',
                   '',
                   'success'
               )
           })


       </script>

<script>

    window.addEventListener('alert-rechazada', event => {

           Swal.fire(
               'Excusa rechazada correctamente',
               '',
               'success'
           )
       })


   </script>
</div>
@include('modals.excusa.createexcusa')
