<div>
    @include('includes.alertas')
    <div class="card card-success mt-2">
        <div class="card-header">

            <div class="row">
                <div class="col-sm-3">
                    <h4>Nuestros Usuarios</h4>
                </div>
                <div class="col-sm-9">
                <div class="input-group  float-right">
                <select  wire:model="cantidad_registros" class="form-select col-sm-2 mr-2" aria-label="Default select example">
                      <option value="10"> 10 </option>
                      <option value="30">30</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
              </select>

                      <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                      <input type="text" class="form-control" placeholder="Buscar usuario" aria-label="Username"
                          aria-describedby="basic-addon1"  wire:model = "buscar">
                          <button type="button" class="btn btn-outline-dark float-right ml-2" data-toggle="modal" data-target="#usuariomodal" >Nuevo usuario <i class="las la-plus-circle"></i></button>
                          <a class="btn btn-outline-light float-right ml-2 text-dark"  href="{{ route('import.index') }}">Importar usuarios <i class="bi bi-cloud-upload-fill"></i></a>

                  </div>
                  </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped" id="tabCategorias">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Firma</th>


                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ ucwords($user->name) }}</td>
                        <td>{{ ($user->email) }}</td>
                        <td>
                            @if($user->firma)
                                <img src="{!! Config::get('app.URL') !!}/storage/archivos/{{ $user->firma }}" style="width:200px; height:75px;"></td>
                            @else
                                <img src="{!! Config::get('app.URL') !!}/img/sin_firma.png"  style="border-radius: 50px; width:50px; height:50px;"></td>
                            @endif

                        <td class="text-center">

                            <a @popper(Actualizar) class="btn btn-outline-success btn-sm" href="#" role="button" data-toggle="modal" data-target="#usuariomodal" wire:click="sendData( {{ $user }} )"><i class="bi bi-pencil-square"></i></a>

                            <button @popper(Eliminar) class="btn btn-outline-danger btn-sm" wire:click="destroy( {{ $user->id }} )"><i class="bi bi-trash3"></i></button>


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
        </div>
        <div class="card-footer">
            <nav class="" aria-label="">
                <ul class="pagination">
                  {{ $users->links() }}
                </ul>
              </nav>
        </div>
    </div>
</div>
