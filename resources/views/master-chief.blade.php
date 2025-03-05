<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memory Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
</head>
<body>
    <div class="container mt-5">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <x-alert typeAlert="error" :message="$error" />
            @endforeach
        @endif

        @if(Session::has('successMsg'))
            <x-alert typeAlert="success" :message="Session::get('successMsg')" />
        @endif

        @if(Session::has('errorMsg'))
            <x-alert typeAlert="error" :message="Session::get('errorMsg')" />
        @endif

        <h1 class="text-center mb-4">
            <img src="{{ asset('img/logo.png') }}" alt="">
        </h1>

        <div class="d-flex mb-3">
            <input type="text" id="search" class="search-bar w-80" placeholder="Pesquisar jogos...">
            {{-- <select class="form-select platform-options" aria-label="platforms" id="platform-options">
                <option selected value="*">Plataforma</option>
            </select> --}}
            <button class="btn btn-custom ms-2 w-20" data-bs-toggle="modal" data-bs-target="#gameModal">Adicionar Jogo</button>
        </div>

        <div id="game-list" class="row justify-content-left">
            <x-card-game :games="$games" :platforms="$platforms" />
        </div>
    </div>

    <x-modal-add-game :platforms="$platformsToSelect" />
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>