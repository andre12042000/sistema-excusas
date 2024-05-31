@section('title', 'Estudiantes')

<div class="py-5">
    @include('includes.alertas')
    <div class="card card-info  mt-2">
        <div class="card-header">

            <div class="row">
                <div class="col-sm-6">
                    <h3>Gestión Estudiantes</h3>
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
                        <input type="text" class="form-control" placeholder="Buscar estudiante" aria-label="Username"
                            aria-describedby="basic-addon1" wire:model="buscar">
                            <a class="btn btn-outline-light float-right ml-2 text-dark"  href="{{ route('import.index.estudiantes') }}">Importar estudiantes <i class="bi bi-cloud-upload-fill"></i></a>


                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Grado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estudiantes as $estudiante)
                            <tr>
                                <td>{{ ucwords($estudiante->name) }}</td>
                                <td>{{ $estudiante->codigo }}</td>
                                <td>{{ $estudiante->grado }}</td>
                                <td class="text-center">
                                    <a @popper(Actualizar) class="btn btn-outline-success btn-sm" href="#"
                                        role="button" data-toggle="modal" data-target="#estudiantemodal"
                                        wire:click="sendData( {{ $estudiante }} )"><i
                                            class="bi bi-pencil-square"></i></a>

                                    <button class="btn btn-outline-danger btn-sm"
                                        wire:click="destroy( {{ $estudiante->id }} )"><i
                                            class="bi bi-trash3"></i></button>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4">
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
                    {{ $estudiantes->links() }}
                </ul>
            </nav>

        </div>
        <!-- Modal para crear estudiantes -->
        <script>
            window.addEventListener('close-modal', event => {
                //alert('Hola mundo');
                $('#brandmodal').hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            })
        </script>
    </div>
</div>
@include('modals.estudiantes.estudiantecreate')
