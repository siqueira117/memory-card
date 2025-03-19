@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Imagem do Jogo -->
        <div class="col-md-4">
            <img src="{{ $game["coverUrl"] }}" class="img-fluid rounded shadow" alt="{{ $game["name"] }}">

            <div class="mt-3">
                @php
                    $isFavorite = auth()->check() && auth()->user()->favorites()->where('game_id', $game['game_id'])->exists();
                @endphp

                <form id="favorite-form" action="{{ url('/favorite/'.$game['game_id']) }}" method="POST">
                    @csrf
                    <button type="button" id="favorite-button" class="btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-warning' }}">
                        <span id="favorite-icon">{{ $isFavorite ? '❤️' : '⭐' }}</span> 
                        <span id="favorite-text">{{ $isFavorite ? 'Remover Favorito' : 'Favoritar' }}</span>
                        <span id="favorite-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
            </div>

            <!-- Carousel de Screenshots -->
            @if(isset($game['screenshots']) && count($game['screenshots']) > 0)
                <div id="gameScreenshots" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($game['screenshots'] as $index => $screenshot)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <!-- Imagem Clicável -->
                                <img src="{{ $screenshot["screenshotUrl"] }}" 
                                    class="d-block w-100 rounded shadow screenshot-thumbnail"
                                    alt="Screenshot {{ $index + 1 }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#screenshotModal"
                                    data-src="{{ $screenshot["screenshotUrl"] }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#gameScreenshots" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#gameScreenshots" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            
                <!-- Modal para Tela Cheia -->
                <div class="modal fade" id="screenshotModal" tabindex="-1" aria-labelledby="screenshotModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="background-color: transparent">
                            <div class="modal-body text-center">
                                <img id="modalImage" src="" class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </div>    
            @endif

            @if(isset($game['artworks']) && count($game['artworks']) > 0)
                <div id="gameArtworks" class="carousel slide mt-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($game['artworks'] as $index => $artwork)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <!-- Imagem Clicável -->
                                <img src="{{ $artwork["artworkUrl"] }}" 
                                    class="d-block w-100 rounded shadow artwork-thumbnail"
                                    alt="Artwork {{ $index + 1 }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#artworkModal"
                                    data-src="{{ $artwork["artworkUrl"] }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#gameArtworks" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#gameArtworks" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            
                <!-- Modal para Tela Cheia -->
                <div class="modal fade" id="artworkModal" tabindex="-1" aria-labelledby="artworkModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="background-color: transparent">
                            <div class="modal-body text-center">
                                <img id="modalImageArtwork" src="" class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </div>    
            @endif
        </div>

        <!-- Detalhes do Jogo -->
        <div class="col-md-8" style="height: max-content">
            <div class="rounded-1 bg-dark-custom p-5">
                <h2 class="fw-bold">{{ $game["name"] }}</h2>

                @if(isset($game['first_release_date']))
                    <p><strong>Lançamento:</strong> {{ date("d/m/Y", strtotime($game['first_release_date'])) }}</p>
                @endif
    
                @if(isset($game['total_rating']))
                    <p><strong>Avaliação: </strong><span class="badge text-bg-success"> {{ round($game['total_rating'], 1) }}/100</span> </p>
                @endif
    
                <p class="mt-3"><strong>Descrição:</strong> {{ $game['summary'] }}</p>
    
                @if(isset($game['storyline']))
                    <p class="mt-3"><strong>Storyline:</strong> {{ $game['storyline'] }}</p>
                @endif
                
                @if(isset($game['genres']))
                    <p><strong>Gêneros:</strong></p>
                    <p>
                        @foreach($game['genres'] as $genre)
                            <span class="badge text-bg-success">{{ $genre['name'] }}</span>
                        @endforeach
                    </p>
                @endif
    
                @if(isset($game['platforms']))
                    <p><strong>Plataformas:</strong></p>
                    <p>
                        @foreach($game['platforms'] as $platform)
                            <span class="badge text-bg-primary">{{ $platform['name'] }}</span>
                        @endforeach
                    </p>
                @endif
                
                @if(isset($game['franchises']) && count($game['franchises']) !== 0 )
                    <p><strong>Franquias:</strong></p>
                    <p>
                        @foreach($game['franchises'] as $franchise)
                            <span class="badge text-bg-warning">{{ $franchise['name'] }}</span>
                        @endforeach
                    </p>
                @endif
    
                <div class="mx-auto w-50">
                    @if(isset($game->manuals) && $game->manuals->isNotEmpty())
                        <div class="dropdown w-100">
                            <a class="btn btn-custom dropdown-toggle" type="button" id="manualDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Baixar Manual
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="manualDropdown">
                                @foreach($game->manuals as $manual)
                                    <li>
                                        <a class="dropdown-item" href="{{ $manual->url }}" target="_blank">
                                            📄 {{ $manual->platform->name }} - {{ $manual->language->locale }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
    
                    <div class="dropdown w-100">
                        <a class="btn btn-custom my-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Download
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($platforms as $platform)
                                <li><a class="dropdown-item" href="{{ $platform['romUrl'] }}">{{ $platform['platform_name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            @if (sizeof($relatedGames) > 0) 
                <div class="rounded-1 bg-dark-custom p-5 mt-3">
                    <h4 class="subtitle mb-3">Jogos relacionados</h4>
                    <div class="row">
                        @foreach ($relatedGames as $game)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                <x-card-game-unique :game="$game" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <div class="row justify-content-end">
        @livewire('game-reviews', ['gameId' => $game->game_id])
    </div>
</div>
@endsection

@section('script')
<script>
    document.getElementById("favorite-button").addEventListener("click", function() {
        let button = document.getElementById("favorite-button");
        let icon = document.getElementById("favorite-icon");
        let text = document.getElementById("favorite-text");
        let spinner = document.getElementById("favorite-spinner");
    
        // Exibe o spinner e desabilita o botão para evitar múltiplos cliques
        spinner.classList.remove("d-none");
        button.disabled = true;
    
        fetch("{{ url('/favorite/'.$game['game_id']) }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message.includes("adicionado")) {
                button.classList.remove("btn-outline-warning");
                button.classList.add("btn-danger");
                icon.innerHTML = "❤️";
                text.innerHTML = "Remover Favorito";
            } else {
                button.classList.remove("btn-danger");
                button.classList.add("btn-outline-warning");
                icon.innerHTML = "⭐";
                text.innerHTML = "Favoritar";
            }
        })
        .catch(error => console.error('Erro:', error))
        .finally(() => {
            // Esconde o spinner e reativa o botão após a requisição
            spinner.classList.add("d-none");
            button.disabled = false;
        });
    });
</script>
@endsection