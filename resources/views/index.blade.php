@extends('layout')

    @section('content')
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

        {{-- <h1 class="text-center mb-4">
            <img id="logo" src="{{ asset('img/logo_purple.png') }}" alt="memorycard">
        </h1> --}}

        @livewire('search-games', ['platforms' => $platforms, 'allGames' => $allGames])
    </div>

    @if( Route::is('masterchief'))
        <x-modal-add-game :platforms="$platformsToSelect" />
    @endif
@endsection