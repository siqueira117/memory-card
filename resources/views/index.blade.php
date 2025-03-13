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
        {{-- <h1 class="text-center mb-4">
            <img id="logo" src="{{ asset('img/logo_purple.png') }}" alt="memorycard">
        </h1> --}}

        @livewire('search-games', ['allGames' => $allGames])
    </div>

    @auth
        @if (Auth::user()->type === 'adm')
            <x-modal-add-game :platforms="$platformsToSelect" />
        @endif
    @endauth

    <x-modal-login />

@endsection