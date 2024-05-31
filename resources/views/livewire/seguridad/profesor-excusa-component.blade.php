@section('title', 'Excusas Aprovadas')

<div class="py-5">
    @include('includes.alertas')
    <div class="card   mt-2">
        <div class="card-header bg-success">

            <div class="row">
                <div class="col-sm-3">
                    <h3>Excusas </h3>
                </div>

                <div class="col-sm-9">
                    <div class="input-group float-right">
                        <select wire:model="filtro_motivo" class="form-select  mr-2" aria-label="Default select example">
                            <option selected>Motivo</option>
                            <option value="UNIFORME">UNIFORME</option>
                            <option value="ENFERMEDAD">ENFERMEDAD</option>
                            <option value="CITA MÉDICA">CITA MÉDICA</option>
                            <option value="CALAMIDAD FAMILIAR">CALAMIDAD FAMILIAR</option>
                            <option value="OTRO">OTRO</option>

                        </select>


                        <select wire:model="select_grado" class="form-select  mr-2" aria-label="Default select example">
                            <option value="">Grado</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>

                        </select>

                        <select wire:model="select_letra" class="form-select  mr-2" aria-label="Default select example">
                            <option value="">letra</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>

                        </select>

                        </select>
                        <select wire:model="filtro_tecnica" class="form-select  mr-2"
                            aria-label="Default select example">
                            <option value="">Técnica</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>


                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <span
                class="badge text-bg-success float-end">{{ ucfirst(\Carbon\Carbon::parse($hoy)->isoFormat('DD MMMM  YYYY')) }}
            </span>
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
                                        data-target="#excusaModal"
                                        wire:click="autorizaciondatos( {{ $excusa }} )"><i
                                            class="bi bi-eye"></i></button>


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

    <script>
        window.addEventListener('alert', event => {

            Swal.fire(
                'Excusa eliminada correctamente',
                '',
                'danger'
            )
        })
    </script>
</div>
@include('modals.excusa.createexcusa')
