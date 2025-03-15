@extends('layout')

    @section('content')
    <div class="container mt-5">
        @auth
            @if (Auth::user()->type === 'adm')
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
        @endauth

        @livewire('search-games', ['allGames' => $allGames])
    </div>

    @auth
        @if (Auth::user()->type === 'adm')
            <x-modal-add-game :platforms="$platformsToSelect" :languages="$languages" />
            <x-modal-add-game-manual :platforms="$platformsToSelect" :languages="$languages" />
        @endif
    @endauth

@endsection