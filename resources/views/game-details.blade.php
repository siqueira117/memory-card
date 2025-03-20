@extends('layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Imagem do Jogo -->
        <div class="col-md-4">
            <img src="{{ $game["coverUrl"] }}" class="img-fluid rounded shadow" alt="{{ $game["name"] }}">

            @auth
                <div class="rounded-1 bg-dark-custom p-3 text-center mt-3" data-game-id="{{ $game['game_id'] }}" id="container-action">
                    @php
                        $isFavorite = auth()->check() && auth()->user()->favorites()->where('game_id', $game['game_id'])->exists();
                    @endphp

                    <!-- Botão de Review -->
                    {{-- <button class="btn btn-custom w-100 mb-3">Log or Review</button> --}}
                
                    <!-- Avaliação (Estrelas) -->
                    {{-- <div class="mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-star {{ 3 >= $i ? 'fas' : 'far' }} text-warning rating-star" data-value="{{ $i }}"></i>
                        @endfor
                    </div> --}}
                
                    <!-- Botões de Status -->
                    <div class="d-flex justify-content-between">
                        @php
                            $userStatus = $game->getUserStatus() ? $game->getUserStatus()->status : null;
                        @endphp
                        <button class="btn {{ $userStatus === 'played' ? 'status-btn-active' : 'status-btn' }}" data-status="played">
                            <i class="fa-solid fa-gamepad"></i>
                            <br> Played
                        </button>
                        <button class="btn {{ $userStatus === 'playing' ? 'status-btn-active' : 'status-btn' }}" data-status="playing">
                            <i class="fa-solid fa-play"></i>
                            <br> Playing
                        </button>
                        <button class="btn {{ $userStatus === 'backlog' ? 'status-btn-active' : 'status-btn' }}" data-status="backlog">
                            <i class="fa-solid fa-book-open"></i>
                            <br> Backlog
                        </button>
                        <button class="btn {{ $userStatus === 'wishlist' ? 'status-btn-active' : 'status-btn' }}" data-status="wishlist">
                            <i class="fa-solid fa-gift"></i>
                            <br> Wishlist
                        </button>
                    </div>
                
                    <!-- Adicionar às listas -->
                    {{-- <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary w-75">📚 Add to lists</button>
                        <button id="favorite-button" class="btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-warning' }}">
                            <span id="favorite-icon">{{ $isFavorite ? '❤️' : '🤍' }}</span>
                        </button>
                    </div> --}}
                </div>
            @endauth

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

            @if ($relatedGames->isNotEmpty())
                <div class="rounded-1 bg-dark-custom p-5 mt-3">
                    <h4 class="subtitle mb-3">Jogos relacionados</h4>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper px-5 py-3">
                            @foreach ($relatedGames as $game)
                                <div class="swiper-slide">
                                    <x-card-game-unique :game="$game" />
                                </div>
                            @endforeach
                        </div>
                        <!-- Botões de navegação -->
                        <div class="swiper-button-next" style="color: #2d961b"></div>
                        <div class="swiper-button-prev" style="color: #2d961b"></div>
                        <!-- Paginação -->
                        <div class="swiper-pagination"></div>
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
    document.addEventListener("DOMContentLoaded", function () {
        let gameContainer = document.getElementById("container-action");
        let gameId = gameContainer ? gameContainer.getAttribute("data-game-id") : null;
    
        // Avaliação com estrelas
        // document.querySelectorAll(".rating-star").forEach(star => {
        //     star.addEventListener("click", function () {
        //         let rating = this.getAttribute("data-value");
    
        //         fetch("/rate-game", {
        //             method: "POST",
        //             headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        //             body: JSON.stringify({ game_id: gameId, rating: rating })
        //         }).then(response => response.json())
        //           .then(data => console.log("Rating salvo:", data));
        //     });
        // });
    
        // Atualizar Status do Jogo
        document.querySelectorAll(".status-btn, .status-btn-active").forEach(button => {
            button.addEventListener("click", function () {
                let status = this.getAttribute("data-status");
                let isActive = this.classList.contains("status-btn-active");

                // Remove a classe de todos os botões antes de ativar o novo
                document.querySelectorAll(".status-btn-active").forEach(btn => {
                    btn.classList.remove("status-btn-active");
                    btn.classList.add("status-btn");
                });

                // Se o botão clicado já estava ativo, apenas desativa
                if (isActive) {
                    status = null;
                    this.classList.remove("status-btn-active");
                    this.classList.add("status-btn");
                } else {
                    this.classList.add("status-btn-active");
                    this.classList.remove("status-btn");
                }

                // Enviar a requisição para atualizar o status
                fetch("{{ route('game.update-status') }}", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: JSON.stringify({ game_id: gameId, status: status })
                })
                .then(response => response.json())
                .then(data => console.log("Status atualizado:", data));
            });
        });

    
        // Favoritar Jogo
        // document.getElementById("favorite-button").addEventListener("click", function () {
        //     let button = this;
        //     let icon = document.getElementById("favorite-icon");
    
        //     fetch("/favorite-game", {
        //         method: "POST",
        //         headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
        //         body: JSON.stringify({ game_id: gameId })
        //     })
        //     .then(response => response.json())
        //     .then(data => {
        //         if (data.favorite) {
        //             button.classList.add("btn-danger");
        //             button.classList.remove("btn-outline-warning");
        //             icon.innerHTML = "❤️";
        //         } else {
        //             button.classList.remove("btn-danger");
        //             button.classList.add("btn-outline-warning");
        //             icon.innerHTML = "🤍";
        //         }
        //     });
        // });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new Swiper(".mySwiper", {
            autoHeight: false,
            effect: 'slide',
            grabCursor: true,
            slidesPerView: 2,
            spaceBetween: 10,
            loop: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 15 },
                768: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 25 },
            }
        });
    });
</script>

    
@endsection