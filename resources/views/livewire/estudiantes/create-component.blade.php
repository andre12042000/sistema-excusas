@section('title', 'Estudiantes')

    <div class="modal-dialog"  theme="primary">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title " id="staticBackdropLabel"> <strong>Gestión de estudiantes</strong> </h5>
                <button type="button" class="btn-close" data-dismiss="modal" wire:click="cancel"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                @include('includes.alertas')
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                        wire:model="name" autofocus>
                    <label for="floatingInput">Nombre completo</label>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                <div class="row">
                    <div class="form-floating col-6 mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                            wire:model="codigo" oninput="this.value = this.value.toUpperCase()">
                        <label for="floatingInput" class="ml-2">Código</label>
                        @error('codigo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="form-group col-6 ">
                        <label for="staticEmail" class=" col-form-label">Inscrito a técnica</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active_si" id="active_si"
                                    value="SI" wire:model.lazy="tecnica">
                                <label class="form-check-label" for="inlineRadio1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active_no" id="active_no"
                                    value="NO" wire:model.lazy="tecnica">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                            @error('tecnica')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group col-6 ">
                        <label for="staticEmail" class=" col-form-label">Usa Ruta</label>
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ruta_si" id="ruta_si"
                                    value="SI" wire:model.lazy="ruta">
                                <label class="form-check-label" for="inlineRadio1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="ruta_no" id="ruta_no"
                                    value="NO" wire:model.lazy="ruta">
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>

                        </div> @error('ruta')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                    </div>

                    <strong class="ml-2">Grado</strong>
                    <hr class="text-success">
                    <div class="form-floating col-5 mb-3">
                        <input type="number"  id="numero" name="numero" min="0" max="11" class="form-control" id="floatingInput" placeholder="name@example.com"
                            wire:model="numero" >
                        <label for="floatingInput" class="ml-2">Número</label>
                        @error('numero')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-2 text-center mt-3"><strong>---</strong> </div>

                    <div class="form-floating col-5 mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com"
                            wire:model="letra" oninput="this.value = this.value.toUpperCase()">
                        <label for="floatingInput" class="ml-2">Letra</label>
                        @error('letra')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

@if($statusadministracion == 0 )
       <button type="button" class="btn btn-success float-right ml-2"
                    wire:click="storeOrupdate" >Guardar</button>
                <x-adminlte-button class="float-right" wire:click="cancel" theme="danger" label="Cancelar"
                    data-dismiss="modal" />
@endif





                <x-slot name="footerSlot" class="mt-0 mb-0 p-0">
                </x-slot>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-modal', event => {
                         //alert('Hola mundo');
                            $('#brandmodal').hide();
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                        })
    </script>



