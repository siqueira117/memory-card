<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memory Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    @livewireStyles
</head>
<body>
    <div class="container mt-5">
        @if( Route::is('masterchief') )
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
        @endif

        <h1 class="text-center mb-4">
            <img id="logo" src="{{ asset('img/logo_purple.png') }}" alt="memorycard">
        </h1>

        @livewire('search-games', ['games' => $games, 'platforms' => $platforms])
    </div>

    @if( Route::is('masterchief'))
        <x-modal-add-game :platforms="$platformsToSelect" />
    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>