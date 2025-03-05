<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memory Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">MemoryCard</h1>

        <div class="d-flex justify-content-evenly mb-3">
            <input type="text" id="search" class="search-bar" placeholder="Pesquisar jogos...">
            {{-- <select class="form-select platform-options" aria-label="platforms" id="platform-options">
                <option selected value="*">Plataforma</option>
            </select> --}}
            {{-- <button class="btn btn-custom ms-2" data-bs-toggle="modal" data-bs-target="#gameModal">Adicionar Jogo</button> --}}
        </div>

        <div id="game-list" class="row justify-content-center">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>