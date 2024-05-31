@section('title', 'Mi Perfil')

<div class="py-5">
    @include('includes.alertas')
    <div class="card card-success ">
        <div class="card-header">
            <h3>Mi Perfil</h3>
        </div>
        <div class="container py-2">
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('name') is-invalid @elseif($name != '') is-valid @enderror" id="floatingInputGrid" placeholder="name@example.com"
                            wire:model="name">
                        <label for="floatingInputGrid">Nombre Completo</label>
                     @error('name')
                  <span class="text-danger">{{ $message }}</span>
              @enderror</div>
                </div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @elseif($email != '') is-valid @enderror" id="floatingInputGrid" placeholder="name@example.com"
                           wire:model="email">
                        <label for="floatingInputGrid">Correo Electrónico</label>
                     @error('email')
                  <span class="text-danger">{{ $message }}</span>
              @enderror</div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="number" class="form-control @error('numero_identificacion') is-invalid @elseif($numero_identificacion != '') is-valid @enderror" id="floatingInputGrid" placeholder="name@example.com"
                        wire:model="numero_identificacion">
                        <label for="floatingInputGrid">Numero de identificación</label>
                     @error('numero_identificacion')
                  <span class="text-danger">{{ $message }}</span>
              @enderror</div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-floating">
                        <input type="number" class="form-control @error('telefono') is-invalid @elseif($telefono != '') is-valid @enderror" id="floatingInputGrid" placeholder="name@example.com"
                        wire:model="telefono">
                        <label for="floatingInputGrid">Telefono</label>
                     @error('telefono')
                  <span class="text-danger">{{ $message }}</span>
              @enderror</div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('direccion') is-invalid @elseif($direccion != '') is-valid @enderror" id="floatingInputGrid" placeholder="name@example.com"
                        wire:model="direccion">
                        <label for="floatingInputGrid">Dirección</label>
                     @error('direccion')
                  <span class="text-danger">{{ $message }}</span>
              @enderror</div>
                </div>
                <div class="col-md-4">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Firma Electronica</label>
                    <input class="form-control @error('firma') is-invalid @elseif($firma != '') is-valid @enderror" type="file" id="formFile" wire:model="firma">
                  @error('firma')
                  <span class="text-danger">{{ $message }}</span>
              @enderror </div>
              @if($firma)
              <div class="mb-4"> <img style="height: 75px; width: 200px;" src="{{ $firma->temporaryUrl() }}" alt="">
              </div>

              @elseif($photo)
              <div class="mb-4"> <img style="height: 75px; width: 200px;" src="{!! Config::get('app.URL') !!}/storage/archivos/{{$photo}}"   alt="">
              </div>

              @endif
                </div>
            </div>
@if (auth()->user()->roles->contains('name', 'Profesor') || auth()->user()->roles->contains('name', 'Coordinador'))
   <hr>
            <strong>Selecciona tus grados</strong>
            <br>
            <div class="row mt-3">
                @foreach($grados as $grado)
                    <div class="col-4">
                        <label>
                            <input type="checkbox" wire:model="selectedGrados" value="{{ $grado }}">
                            {{ $grado }}
                        </label>
                    </div>
                @endforeach
            </div>
@endif




            <button class="btn btn-outline-success col-md-12" wire:click="update">Actualizar</button>
        </div>
    </div>
</div>
