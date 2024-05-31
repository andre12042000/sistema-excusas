<div class="modal-dialog" theme="primary">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title " id="staticBackdropLabel"> <strong>Gestión de
                    usuario</strong> </h5>
            <button type="button" class="btn-close" data-dismiss="modal" wire:click="cleanData"
                aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <div>
                @include('includes.alertas')
                <div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Nombres<span
                                class="fs-6 text-danger ml-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Campo obligatorio">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="name" id="name" name="name"
                                class="form-control @if($name == '') @else @error('name') is-invalid @else is-valid @enderror @endif"
                                id="exampleFormControlInput1" placeholder="Ejemplo: Juan García" autofocus autocomplete="off">

                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Email<span
                                class="fs-6 text-danger ml-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Campo obligatorio">*</span></label>
                        <div class="col-sm-8">
                            <input type="email" wire:model.lazy="email"
                                class="form-control @if($email == '') @else @error('email') is-invalid @else is-valid @enderror @endif"
                                id="exampleFormControlInput1" placeholder="email@example.com" autocomplete="off">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Telefono<span
                                class="fs-6 text-danger ml-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Campo obligatorio">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" wire:model.lazy="telefono"
                                class="form-control @if($telefono == '') @else @error('telefono') is-invalid @else is-valid @enderror @endif"
                                id="exampleFormControlInput1" placeholder="Telefono" autocomplete="off">
                            @error('telefono')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Dirección<span
                                class="fs-6 text-danger ml-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Campo obligatorio">*</span></label>
                        <div class="col-sm-8">
                            <input type="email" wire:model.lazy="direccion"
                                class="form-control @if($direccion == '') @else @error('direccion') is-invalid @else is-valid @enderror @endif"
                                id="exampleFormControlInput1" placeholder="Calle 4 # 44-44" autocomplete="off">
                            @error('direccion')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Identificación<span
                                class="fs-6 text-danger ml-2" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Campo obligatorio">*</span></label>
                        <div class="col-sm-8">
                            <input type="email" wire:model.lazy="numero_identificacion"
                                class="form-control @if($numero_identificacion == '') @else @error('numero_identificacion') is-invalid @else is-valid @enderror @endif"
                                id="exampleFormControlInput1" placeholder="Identificación" autocomplete="off">
                            @error('numero_identificacion')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-4 col-form-label">Firma</label>
                        <div class="col-sm-8">
                            <input type="file"
                                class="form-control @if($photo == '') @else @error('photo') is-invalid @else is-valid @enderror @endif"
                                id="inputEmail4" wire:model.lazy="photo">
                            @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>






                    <div class="form-group row">

                        <div class="col-sm-6">
                            <label class="mt-3">Listado de roles</label>
                            <hr>
                            @foreach ($roles as $rol)
                            <div class="d-flex py-2">
                                <input type="checkbox" wire:model="rol_usuario" value="{{ $rol->id }}"
                                    class="d-inline-block mr-2" />
                                &nbsp;
                                &nbsp;{{ $rol->name }}
                            </div>
                            @endforeach

                            @error('rol_usuario')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6">

                            @if($image)
                            <label class="mt-3">firma</label>
                            <hr>
                            <div class="mb-4"> <img style="height: 75px; width: 200px;"
                                    src="{!! Config::get('app.URL') !!}/storage/archivos/{{ $image }}" alt="">
                            </div>

                            @elseif($photo)
                            <label class="mt-3">firma</label>
                            <hr>
                            <div class="mb-4"> <img style="height: 150px; width: 150px;"
                                    src="{{ $photo->temporaryUrl() }}" alt="">
                            </div>

                            @endif
                        </div>

                    </div>



                    <button type="button" class="btn btn-success float-right ml-2"
                        wire:click="storeOrupdate">Guardar</button>
                    <x-adminlte-button class="float-right" wire:click="cleanData" theme="danger" label="Cancelar"
                        data-dismiss="modal" />

                    <x-slot name="footerSlot" class="mt-0 mb-0 p-0">
                        <small id="emailHelp" class="form-text text-muted">* Campo obligatorio</small>
                    </x-slot>


                </div>

            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener('alert', event => {

        Swal.fire(
            'Usuario actualizado correctamente',
            '',
            'success'
        )
    })


</script>
<script>
    window.addEventListener('close-modal', event => {
                     //alert('Hola mundo');
                        $('#usuariomodal').hide();
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    })
</script>
