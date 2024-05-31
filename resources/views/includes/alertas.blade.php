@if(session()->has('message'))

    <div class="alert alert-success alert-dismissible fade show t:0.2 mt-2 " role="alert">
        <i class="bi bi-check-circle-fill"></i> {{session('message')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>


@endif

@if(session()->has('delete'))

    <div class="alert alert-danger alert-dismissible fade show t:0.2 mt-2  " role="alert">
    <i class="bi bi-exclamation-triangle bold"></i> {{session('delete')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>


@endif
@if(session()->has('warning'))

    <div class="alert alert-warning alert-dismissible fade show t:0.2 mt-2 " role="alert">
    <i class="bi bi-exclamation-triangle bold"></i> {{session('warning')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>


@endif

@if(session()->has('error'))

    <div class="alert alert-danger alert-dismissible fade show t:0.2 mt-2 " role="alert">
    <i class="bi bi-exclamation-triangle bold"></i> {{session('error')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
