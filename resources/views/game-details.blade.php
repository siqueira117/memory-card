@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Imagem do Jogo -->
        <div class="col-md-4">
            <img src="{{ $game->coverUrl }}" class="img-fluid rounded shadow" alt="{{ $game['name'] }}">
        </div>

        <!-- Informações do Jogo -->
        <div class="col-md-8">
            <h1 class="mb-3">{{ $game['name'] }}</h1>
            <p class="text-muted">{{ $game['description'] }}</p>

            <!-- Dropdown de Download -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Download
                </button>
                <ul class="dropdown-menu">
                    {{-- @foreach ($platforms as $platform)
                        <li><a class="dropdown-item" href="{{ $platform->romUrl }}">{{ $platform->platform_name }}</a></li>
                    @endforeach --}}
                </ul>
            </div>

            <!-- Botão Voltar -->
            <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Voltar</a>
        </div>
    </div>
</div>
@endsection