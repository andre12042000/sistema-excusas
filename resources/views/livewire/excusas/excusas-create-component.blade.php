<div>
    <div class="modal-dialog modal-lg  " theme="primary">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title " id="staticBackdropLabel"> <strong>Gestión de excusas</strong> </h5>
                <button type="button" class="btn-close" data-dismiss="modal" wire:click="cancel"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-lg-2 text-center" style=" border: 1px solid #ccc;">
                        <img class="mt-2" src="{!! Config::get('app.URL') !!}/img/logo.png" width="80px" height="100px">
                    </div>
                    <div class="col-lg-8 text-center" style=" border: 1px solid #ccc;">
                        <strong>INSTITUCIÓN EDUCATIVA EL CUSIANA</strong><br>
                        <strong>JORNADA UNICA</strong> <br>
                        <strong>RES Nº 1627 de julio 28 de 2023 - DANE</strong><br>
                        <strong>285410000649 - NIT 844002722-0</strong><br>
                        <span>Rector: William Fernando Cuervo López</span><br>

                        <span class="py-1">CONTROL DE SALIDAS Y EXCUSAS</span>
                    </div>
                    <div class="col-lg-2 text-center" style=" border: 1px solid #ccc;">

                        <strong>Consecutivo &nbsp;</strong> <span> {{ $codigo }}</span><br>
                        <strong>Fecha Excusa</strong> <span>
                            @if ($fecha_radicado)
                                {{ ucfirst(\Carbon\Carbon::parse($fecha_radicado)->isoFormat('DD MMMM  YYYY')) }}
                            @else
                                {{ ucfirst(\Carbon\Carbon::parse($fecha_hoy)->isoFormat('DD MMMM  YYYY')) }}
                            @endif
                        </span> <br>
                    </div>
                </div>
                @include('includes.alertas')
                <p class="py-2 text-justify">
                    Nombre del estudiante(a):
                    <select style="border-radius: 5px;" wire:model="estudiante_id"
                        @if ($show == 1) disabled @endif
                        class="form-select d-inline-block w-auto  @error('estudiante_id') is-invalid @elseif($estudiante_id != '') is-valid @enderror">
                        <option value="">Selecciona un estudiante</option>
                        @foreach ($estudiantes as $estudiante)
                            <option value="{{ $estudiante->id }}">{{ strtoupper($estudiante->name) }}</option>
                        @endforeach
                    </select>
                    del grado
                    <input type="text" id="grado" name="grado"
                        @if ($show == 1) disabled @endif
                        class="form-control d-inline-block col-auto mt-2  @error('grado') is-invalid @elseif($grado != '') is-valid @enderror"
                       style="width: auto" placeholder="Grado" readonly wire:model="grado">
                    asiste a técnica
                    <input type="text" id="edad" name="edad"
                        @if ($show == 1) disabled @endif
                        class="form-control d-inline-block col-auto mt-2 @error('tecnica') is-invalid @elseif($tecnica != '') is-valid @enderror"
                        style="width: auto" placeholder="Técnica" readonly wire:model="tecnica">

                    hace uso de la ruta
                    <input type="text" id="ruta" name="ruta"
                        @if ($show == 1) disabled @endif
                        class="form-control d-inline-block col-auto mt-2 @error('ruta') is-invalid @elseif($ruta != '') is-valid @enderror"
                        style="width: auto" placeholder="Ruta" readonly wire:model="ruta">
                    <hr>
                <div class="text-center">
                    <strong class="float-center">TIPO Y MOTIVO POR EL CUAL SE SOLICITA LA EXCUSA </strong>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <select
                            class="form-select @error('motivo') is-invalid @elseif($motivo != '') is-valid @enderror"
                            aria-label="Default select example" wire:model = "motivo">
                            <option selected>Selecciona el motivo</option>
                            <option value="UNIFORME">UNIFORME</option>
                            <option value="ENFERMEDAD">ENFERMEDAD</option>
                            <option value="CITA MÉDICA">CITA MÉDICA</option>
                            <option value="CALAMIDAD FAMILIAR">CALAMIDAD FAMILIAR</option>
                            <option value="OTRO">OTRO</option>

                        </select>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-end">
                            <div class="form-check form-check-inline ml-5">
                                <input @if ($show == 1) disabled @endif class="form-check-input mt-1"
                                    type="radio" name="tipo_si" id="tipo_si" value="SALIDA" wire:model= "tipo">
                                <label class="form-check-label" for="inlineRadio1">SALIDA</label>
                            </div>
                            <div class="form-check form-check-inline ml-5">
                                <input @if ($show == 1 || ($bloque_hora = 1)) disabled @endif class="form-check-input mt-1"
                                    type="radio" name="tipo_no" id="tipo_no" value="EXCUSA" wire:model= "tipo">
                                <label class="form-check-label" for="inlineRadio2">EXCUSA</label>
                            </div>
                        </div>
                    </div>
                </div>




                @if ($motivo == 'OTRO')
                    <textarea name="" id="" rows="2" wire:model="motivo_descripcion"
                        @if ($show == 1) disabled @endif
                        class="form-control mt-2  @error('motivo_descripcion') is-invalid @elseif($motivo_descripcion != '') is-valid @enderror"
                        placeholder="Describe el motivo"></textarea>
                @endif


                <hr>
                <strong>Tiempo </strong><br>
                Horas: <input style="width: auto"type="number" id="horas" name="horas"
                    @if ($show == 1) disabled @endif
                    class="form-control d-inline-block  mt-2 mr-3 @error('horas') is-invalid @elseif($horas != '') is-valid @enderror"
                    wire:model="horas">

                Salida:
                <input style="width: auto" type="time" id="hora_exacta" name="hora_exacta"
                    @if ($show == 1) disabled @endif
                    class="form-control d-inline-block  mt-2 ml-2
                           @error('hora_exacta') is-invalid
                           @elseif($hora_exacta != '') is-valid
                           @enderror"
                    wire:model="hora_exacta">




                <div class="form-check form-check-inline ml-2">
                    <input @if ($show == 1) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox1" value="SI" wire:model="primera_hora">
                    <label class="form-check-label" for="inlineCheckbox1">1</label>
                </div>
                <div class="form-check form-check-inline">
                    <input @if ($show == 1) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox2" value="SI" wire:model="segunda_hora">
                    <label class="form-check-label" for="inlineCheckbox2">2</label>
                </div>
                <div class="form-check form-check-inline">
                    <input @if ($show == 1) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox3" value="SI" wire:model="tercera_hora">
                    <label class="form-check-label" for="inlineCheckbox3">3 </label>
                </div>

                <div class="form-check form-check-inline">
                    <input @if ($show == 1) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox4" value="SI" wire:model="cuarta_hora">
                    <label class="form-check-label" for="inlineCheckbox4">4 </label>
                </div>

                <div class="form-check form-check-inline">
                    <input @if ($show == 1) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox5" value="SI" wire:model="quinta_hora">
                    <label class="form-check-label" for="inlineCheckbox5">5 </label>
                </div>

                <div class="form-check form-check-inline">
                    <input @if ($show == 1 || $numero <= 5) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox6" value="SI" wire:model="sexta_hora">
                    <label class="form-check-label" for="inlineCheckbox6">6 </label>
                </div>

                <div class="form-check form-check-inline">
                    <input @if ($show == 1 || $numero <= 5) disabled @endif class="form-check-input mt-1"
                        type="checkbox" id="inlineCheckbox7" value="SI" wire:model="septima_hora">
                    <label class="form-check-label" for="inlineCheckbox7">7 </label>
                </div>
                <br>
                Dias: <input  type="text" id="dias" name="dias"
                    @if ($show == 1) disabled @endif class="form-control d-inline-block col-2 mt-2 "
                    wire:model="dias" readonly min="{{ now()->format('Y-m-d') }}">
                <span class="ml-2">Fecha</span> <input type="date" id="dato2" name="dato2"
                    @if ($show == 1) disabled @endif
                    class="form-control d-inline-block w-auto mt-2 @error('fecha_inicial') is-invalid @elseif($fecha_inicial != '') is-valid @enderror"
                    wire:model="fecha_inicial">
                Hasta
                <input type="date" id="dato3" name="dato3"
                    @if ($show == 1) disabled @endif
                    class="form-control d-inline-block w-auto mt-2 @error('fecha_final') is-invalid @elseif($fecha_final != '') is-valid @enderror"
                    wire:model="fecha_final"  min="{{ $fecha_inicial ?? now()->format('Y-m-d') }}">

                <hr>
                <br>

                Anexo copia de soportes (Documento PDF)
                <input type="file" class="form-control-file mt-2 col-6" wire:model="documento"
                    @if ($show == 1) disabled @endif>
                @error('documento')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @if ($documento != null && $documentocon != null)
                    <a href="{{ route('file.download', $documento) }}" target="_blank">Descargar Soporte</a>
                @endif
                </p>


                <div class="row text-center">
                    <div class="col-lg-3">
                        @if ($padre_id)
                            {{ $padre_id->name }}
                        @else
                            {{ $padre->name }}
                        @endif
                        <strong class="subrayado-top">Nombre del acudiente</strong>
                    </div>
                    <div class="col-lg-3">
                        @if ($padre_id)
                            {{ $padre_id->numero_identificacion }}
                        @else
                            {{ $padre->numero_identificacion }}
                        @endif
                        <br><br>
                        <strong class="subrayado-top">Documento acudiente</strong>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="telefono" name="telefono"
                            @if ($show == 1) disabled @endif
                            class="form-control d-inline-block col-12 mt-2  @error('telefono') is-invalid @elseif($telefono != '') is-valid @enderror"
                            placeholder="Ingresa telefono" wire:model="telefono">


                        <strong class="subrayado-top">Telefono del acudiente</strong>
                    </div>
                    <div class="col-lg-3">
                        @if ($padre_id)
                            <div>
                                <img style="height: 48px; width: 145px;"
                                    src="{!! Config::get('app.URL') !!}/storage/archivos/{{ $padre_id->firma }}"
                                    alt="">
                            </div>
                        @else
                            @if ($padre->firma)
                                <div>
                                    <img style="height: 48px; width: 145px;"
                                        src="{!! Config::get('app.URL') !!}/storage/archivos/{{ $padre->firma }}"
                                        alt="">
                                </div>
                            @endif
                        @endif

                        <strong class="subrayado-top">Firma del acudiente</strong>
                    </div>

                </div>
                <div class="row mt-3">

                    {{-- <div class="col-lg-6 "> <br>
                        @if ($fecha_radicado)
                            {{ ucfirst(\Carbon\Carbon::parse($fecha_radicado)->isoFormat('DD MMMM  YYYY')) }}
                        @else
                            {{ ucfirst(\Carbon\Carbon::parse($fecha_hoy)->isoFormat('DD MMMM  YYYY')) }}
                        @endif <br>
                        <strong class="subrayado-top colorprueba">Fecha radicado</strong>
                    </div> --}}
                    <div class="col-lg-12 text-center "> <br>
                        @if ($firma_coordinador != 'null')
                            <img style="height: 48px; width: 170px;"
                                src="{!! Config::get('app.URL') !!}/storage/archivos/{{ $firma_coordinador }}"
                                alt="">
                            <br>
                        @else
                            @can('Autorización Excusas')
                                <img style="height: 48px; width: 170px; opacity: 0.5;"
                                    src="{!! Config::get('app.URL') !!}/storage/archivos/{{ $firma }}" alt="">
                                <br>
                            @endcan
                        @endif
                        <strong class="subrayado-top">Autoriza Coordinacióm</strong>
                    </div>

                </div>
                @if ($mostrarobservvacion == 1 || $observaciones != '')
                    <textarea name="" id="" rows="2" wire:model="observaciones"
                        @if ($observaciones2 != '') disabled @endif
                        class="form-control mt-2 py-2  @error('observaciones') is-invalid @elseif($observaciones != '') is-valid @enderror"
                        placeholder="Describe el motivo por el cual se rechaza la excusas"></textarea>
                @endif


                @if ($firma == null)
                    <div class="alert alert-danger d-flex align-items-center mt-2" role="alert">
                        <strong><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                                <path
                                    d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" />
                                <path
                                    d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />
                            </svg> </strong>
                        <div>
                            Debes actualizar tu perfil y subir una imagen de tu firma! <a
                                href="{{ route('actualizar.perfil') }}" class="alert-link">ir a mi perfil</a>
                        </div>
                    </div>
                @endif
                </body>
                <div class="modal-footer">
                    @can('Autorización Excusas')
                        <button class="btn btn-outline-success float-left"
                            wire:click="autorizacion( {{ $selected_id }} )"
                            @if ($status == 'APROVADO' || $status == 'RECHAZADO' || $padre_id == '') disabled @endif
                            @if ($firma == null) disabled @endif>Autorizar Excusa <i
                                class="far fa-paper-plane"></i></button>
                        <button class="btn btn-outline-danger float-left" wire:click="rechazado( {{ $selected_id }} )"
                            @if ($status == 'APROVADO' || $status == 'RECHAZADO' || $padre_id == '') disabled @endif
                            @if ($firma == null) disabled @endif>Rechazar Excusa <i
                                class="fas fa-ban"></i></button>
                    @endcan

                    <button class="btn btn-outline-primary float-end" wire:click="send"
                        @if ($show == 1) disabled @endif
                        @if ($firma == null) disabled @endif>Enviar
                        excusa <i class="far fa-paper-plane"></i></button>
                </div>

            </div>
        </div>
    </div>





    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .subrayado-top {
            position: relative;
            display: inline-block;
        }

        .subrayado-top::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 0.5px;
            /* Grosor del subrayado */
            background-color: rgb(0, 0, 0);
            /* Color del subrayado */
            top: 0;
            left: 0;
        }
    </style>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    window.addEventListener('alert', event => {

           Swal.fire(
               'Excusa enviada correctamente',
               '',
               'success'
           )
       })


   </script>
</div>
<script>
    window.addEventListener('close-modal', event => {
        //alert('Hola mundo');
        $('#excusaModal').hide();
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    })
</script>
