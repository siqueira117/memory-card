@switch($typeAlert)

    @case("success")
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCESSO: </strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @break

    @case("error")
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR: </strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @break

@endswitch