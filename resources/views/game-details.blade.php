@extends('layout')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section with Cover -->
    <div class="game-hero position-relative" style="background: linear-gradient(135deg, rgba(15, 15, 18, 0.95), rgba(26, 26, 31, 0.9)), url('{{ $game["coverUrl"] }}') center/cover;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="game-cover-wrapper">
                        <img src="{{ $game["coverUrl"] }}" class="game-cover img-fluid" alt="{{ $game["name"] }}">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="game-header-info">
                        <h1 class="game-title mb-3">{{ $game["name"] }}</h1>
                        
                        <div class="game-meta d-flex flex-wrap gap-3 mb-4">
                            @if(isset($game['first_release_date']))
                                <div class="meta-item">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <span>{{ date("Y", strtotime($game['first_release_date'])) }}</span>
                                </div>
                            @endif
                            
                            @if(isset($game['total_rating']))
                                <div class="meta-item">
                                    <i class="fas fa-star me-2"></i>
                                    <span>{{ round($game['total_rating'], 1) }}/100</span>
                                </div>
                            @endif
                            
                            @if(isset($game['genres']) && count($game['genres']) > 0)
                                <div class="meta-item">
                                    <i class="fas fa-tag me-2"></i>
                                    <span>{{ $game['genres'][0]['name'] }}</span>
                                </div>
                            @endif
                        </div>

                        @if(isset($game['genres']))
                            <div class="game-badges mb-3">
                                @foreach($game['genres'] as $genre)
                                    <span class="badge-genre">
                                        <i class="fas fa-gamepad me-1"></i>{{ $genre['name'] }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- User Actions Card -->
            @auth
                <div class="info-card mb-4" data-game-id="{{ $game['game_id'] }}" id="container-action">
                    <div class="info-card-header">
                        <i class="fas fa-user-circle me-2"></i>
                        <h5 class="mb-0">Suas Ações</h5>
                    </div>
                    <div class="info-card-body">
                        @php
                            $userStatus = $game->getUserStatus() ? $game->getUserStatus()->status : null;
                        @endphp
                        
                        <div class="status-grid">
                            <button class="status-card {{ $userStatus === 'played' ? 'active' : '' }}" data-status="played">
                                <div class="status-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <span class="status-label">Jogado</span>
                            </button>
                            
                            <button class="status-card {{ $userStatus === 'playing' ? 'active' : '' }}" data-status="playing">
                                <div class="status-icon">
                                    <i class="fas fa-play-circle"></i>
                                </div>
                                <span class="status-label">Jogando</span>
                            </button>
                            
                            <button class="status-card {{ $userStatus === 'backlog' ? 'active' : '' }}" data-status="backlog">
                                <div class="status-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <span class="status-label">Backlog</span>
                            </button>
                            
                            <button class="status-card {{ $userStatus === 'wishlist' ? 'active' : '' }}" data-status="wishlist">
                                <div class="status-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <span class="status-label">Wishlist</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Game Info Card -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <i class="fas fa-info-circle me-2"></i>
                    <h5 class="mb-0">Informações</h5>
                </div>
                <div class="info-card-body">
                    @if(isset($game['first_release_date']))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-calendar-alt me-2"></i>Lançamento
                            </div>
                            <div class="info-value">{{ date("d/m/Y", strtotime($game['first_release_date'])) }}</div>
                        </div>
                    @endif

                    @if(isset($game['total_rating']))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-star me-2"></i>Avaliação
                            </div>
                            <div class="info-value">
                                <span class="rating-badge">{{ round($game['total_rating'], 1) }}/100</span>
                            </div>
                        </div>
                    @endif

                    @if(isset($game['platforms']))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-desktop me-2"></i>Plataformas
                            </div>
                            <div class="info-value">
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($game['platforms'] as $platform)
                                        <span class="badge-platform">{{ $platform['name'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($game['franchises']) && count($game['franchises']) > 0)
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fas fa-layer-group me-2"></i>Franquia
                            </div>
                            <div class="info-value">
                                @foreach($game['franchises'] as $franchise)
                                    <span class="badge-franchise">{{ $franchise['name'] }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Download Card -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <i class="fas fa-download me-2"></i>
                    <h5 class="mb-0">Downloads</h5>
                </div>
                <div class="info-card-body">
                    @if(isset($game->manuals) && $game->manuals->isNotEmpty())
                        <button class="download-btn mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#manualsCollapse">
                            <i class="fas fa-book me-2"></i>
                            <span>Manuais ({{ $game->manuals->count() }})</span>
                            <i class="fas fa-chevron-down ms-auto"></i>
                        </button>
                        
                        <div class="collapse" id="manualsCollapse">
                            <div class="download-list">
                                @foreach($game->manuals as $manual)
                                    <a href="{{ $manual->url }}" target="_blank" class="download-item">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        <span>{{ $manual->platform->name }} - {{ $manual->language->locale }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(count($platforms) > 0)
                        <button class="download-btn" type="button" data-bs-toggle="collapse" data-bs-target="#romsCollapse">
                            <i class="fas fa-gamepad me-2"></i>
                            <span>ROMs ({{ count($platforms) }})</span>
                            <i class="fas fa-chevron-down ms-auto"></i>
                        </button>
                        
                        <div class="collapse show" id="romsCollapse">
                            <div class="download-list">
                                @foreach($platforms as $platform)
                                    <a href="{{ $platform['romUrl'] }}" class="download-item">
                                        <i class="fas fa-download me-2"></i>
                                        <span>{{ $platform['platform_name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Description Section -->
            <div class="content-card mb-4">
                <div class="content-card-header">
                    <i class="fas fa-align-left me-2"></i>
                    <h4 class="mb-0">Sobre o Jogo</h4>
                </div>
                <div class="content-card-body">
                    <p class="game-description">{{ $game['summary'] }}</p>
                    
                    @if(isset($game['storyline']))
                        <div class="storyline-section mt-4">
                            <h5 class="section-subtitle">
                                <i class="fas fa-book-open me-2"></i>História
                            </h5>
                            <p class="game-storyline">{{ $game['storyline'] }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Screenshots Section -->
            @if(isset($game['screenshots']) && count($game['screenshots']) > 0)
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <i class="fas fa-images me-2"></i>
                        <h4 class="mb-0">Screenshots</h4>
                    </div>
                    <div class="content-card-body p-0">
                        <div id="gameScreenshots" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($game['screenshots'] as $index => $screenshot)
                                    <button type="button" data-bs-target="#gameScreenshots" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                                @endforeach
                            </div>
                            
                            <div class="carousel-inner">
                                @foreach($game['screenshots'] as $index => $screenshot)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $screenshot["screenshotUrl"] }}" 
                                            class="d-block w-100 screenshot-img"
                                            alt="Screenshot {{ $index + 1 }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#screenshotModal"
                                            data-src="{{ $screenshot["screenshotUrl"] }}"
                                            style="cursor: pointer;">
                                    </div>
                                @endforeach
                            </div>
                            
                            <button class="carousel-control-prev" type="button" data-bs-target="#gameScreenshots" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#gameScreenshots" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Artworks Section -->
            @if(isset($game['artworks']) && count($game['artworks']) > 0)
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <i class="fas fa-palette me-2"></i>
                        <h4 class="mb-0">Artworks</h4>
                    </div>
                    <div class="content-card-body p-0">
                        <div id="gameArtworks" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($game['artworks'] as $index => $artwork)
                                    <button type="button" data-bs-target="#gameArtworks" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                                @endforeach
                            </div>
                            
                            <div class="carousel-inner">
                                @foreach($game['artworks'] as $index => $artwork)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $artwork["artworkUrl"] }}" 
                                            class="d-block w-100 screenshot-img"
                                            alt="Artwork {{ $index + 1 }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#artworkModal"
                                            data-src="{{ $artwork["artworkUrl"] }}"
                                            style="cursor: pointer;">
                                    </div>
                                @endforeach
                            </div>
                            
                            <button class="carousel-control-prev" type="button" data-bs-target="#gameArtworks" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#gameArtworks" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Games Section -->
            @if($relatedGames->isNotEmpty())
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <i class="fas fa-link me-2"></i>
                        <h4 class="mb-0">Jogos Relacionados</h4>
                    </div>
                    <div class="content-card-body">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach($relatedGames as $relatedGame)
                                    <div class="swiper-slide">
                                        <x-card-game-unique :game="$relatedGame" />
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row">
        <div class="col-12">
            @livewire('game-reviews', ['gameId' => $game->game_id])
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="screenshotModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background-color: transparent; border: none;">
            <div class="modal-body p-0">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 1;"></button>
                <img id="modalImage" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="artworkModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background-color: transparent; border: none;">
            <div class="modal-body p-0">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" style="z-index: 1;"></button>
                <img id="modalImageArtwork" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

@endsection

@section('style')
<style>
/* Game Hero Section */
.game-hero {
    min-height: 400px;
    border-bottom: 3px solid var(--btn-color);
}

.game-cover-wrapper {
    position: relative;
}

.game-cover {
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    border: 3px solid rgba(45, 150, 27, 0.3);
    transition: all 0.3s ease;
}

.game-cover:hover {
    transform: scale(1.05);
    border-color: var(--btn-color);
    box-shadow: 0 25px 70px rgba(45, 150, 27, 0.4);
}

.game-title {
    font-size: 3rem;
    font-weight: 800;
    color: var(--text-primary);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    line-height: 1.2;
}

.game-meta {
    font-size: 1.1rem;
}

.meta-item {
    display: inline-flex;
    align-items: center;
    background: rgba(45, 150, 27, 0.2);
    padding: 8px 16px;
    border-radius: 20px;
    color: var(--text-accent);
    font-weight: 600;
}

.meta-item i {
    color: var(--btn-color);
}

.badge-genre {
    display: inline-block;
    background: var(--btn-gradient);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0 5px 5px 0;
    box-shadow: 0 4px 12px rgba(45, 150, 27, 0.3);
}

/* Info Card */
.info-card {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
}

.info-card:hover {
    border-color: rgba(45, 150, 27, 0.3);
    box-shadow: 0 12px 32px rgba(45, 150, 27, 0.2);
}

.info-card-header {
    background: rgba(45, 150, 27, 0.1);
    padding: 15px 20px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.info-card-header i {
    color: var(--btn-color);
    font-size: 1.2rem;
}

.info-card-header h5 {
    color: var(--text-primary);
    font-weight: 700;
}

.info-card-body {
    padding: 20px;
}

/* Status Grid */
.status-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.status-card {
    background: var(--dark-color);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.status-card:hover {
    background: rgba(45, 150, 27, 0.1);
    border-color: var(--btn-color);
    transform: translateY(-3px);
}

.status-card.active {
    background: var(--btn-gradient);
    border-color: var(--btn-color);
    box-shadow: 0 8px 24px rgba(45, 150, 27, 0.4);
}

.status-icon {
    font-size: 2rem;
    color: var(--text-secondary);
}

.status-card.active .status-icon {
    color: white;
}

.status-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-secondary);
}

.status-card.active .status-label {
    color: white;
}

/* Info Items */
.info-item {
    padding: 12px 0;
    border-bottom: 1px solid var(--border-color);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 600;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
}

.info-label i {
    color: var(--btn-color);
}

.info-value {
    color: var(--text-primary);
    font-weight: 500;
}

.rating-badge {
    background: var(--btn-gradient);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(45, 150, 27, 0.3);
}

.badge-platform, .badge-franchise {
    display: inline-block;
    background: rgba(45, 150, 27, 0.2);
    color: var(--text-accent);
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    border: 1px solid rgba(45, 150, 27, 0.3);
}

/* Download Section */
.download-btn {
    width: 100%;
    background: var(--dark-color);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    color: var(--text-primary);
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
}

.download-btn:hover {
    background: rgba(45, 150, 27, 0.1);
    border-color: var(--btn-color);
}

.download-btn i:first-child {
    color: var(--btn-color);
}

.download-list {
    margin-top: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.download-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    background: rgba(45, 150, 27, 0.05);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    color: var(--text-primary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.download-item:hover {
    background: rgba(45, 150, 27, 0.15);
    border-color: var(--btn-color);
    transform: translateX(5px);
    color: var(--text-accent);
}

.download-item i {
    color: var(--btn-color);
}

/* Content Card */
.content-card {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.content-card-header {
    background: rgba(45, 150, 27, 0.1);
    padding: 20px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.content-card-header i {
    color: var(--btn-color);
    font-size: 1.3rem;
}

.content-card-header h4 {
    color: var(--text-primary);
    font-weight: 700;
}

.content-card-body {
    padding: 24px;
}

.game-description {
    font-size: 1.05rem;
    line-height: 1.8;
    color: var(--text-secondary);
}

.storyline-section {
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.section-subtitle {
    color: var(--text-accent);
    font-weight: 700;
    margin-bottom: 12px;
}

.section-subtitle i {
    color: var(--btn-color);
}

.game-storyline {
    font-size: 1rem;
    line-height: 1.7;
    color: var(--text-secondary);
}

/* Screenshots */
.screenshot-img {
    height: 450px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.screenshot-img:hover {
    transform: scale(1.02);
}

.carousel-indicators button {
    background-color: var(--btn-color);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(45, 150, 27, 0.8);
    border-radius: 50%;
    padding: 20px;
}

/* Swiper Custom */
.swiper-button-next,
.swiper-button-prev {
    color: var(--btn-color) !important;
    background: rgba(15, 15, 18, 0.8);
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px;
}

.swiper-pagination-bullet-active {
    background-color: var(--btn-color) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .game-title {
        font-size: 2rem;
    }
    
    .game-meta {
        font-size: 0.95rem;
    }
    
    .status-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .screenshot-img {
        height: 250px;
    }
}
</style>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let gameContainer = document.getElementById("container-action");
    let gameId = gameContainer ? gameContainer.getAttribute("data-game-id") : null;

    // Status buttons
    document.querySelectorAll(".status-card").forEach(button => {
        button.addEventListener("click", function () {
            let status = this.getAttribute("data-status");
            let isActive = this.classList.contains("active");

            // Remove active class from all buttons
            document.querySelectorAll(".status-card").forEach(btn => {
                btn.classList.remove("active");
            });

            // Toggle active state
            if (!isActive) {
                this.classList.add("active");
            } else {
                status = null;
            }

            // Send request
            fetch("{{ route('game.update-status') }}", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json", 
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                },
                body: JSON.stringify({ game_id: gameId, status: status })
            })
            .then(response => response.json())
            .then(data => console.log("Status atualizado:", data));
        });
    });

    // Screenshot modal
    document.querySelectorAll('.screenshot-thumbnail, [data-bs-target="#screenshotModal"]').forEach(item => {
        item.addEventListener('click', function () {
            document.getElementById('modalImage').src = this.getAttribute('data-src');
        });
    });

    // Artwork modal
    document.querySelectorAll('.artwork-thumbnail, [data-bs-target="#artworkModal"]').forEach(item => {
        item.addEventListener('click', function () {
            document.getElementById('modalImageArtwork').src = this.getAttribute('data-src');
        });
    });

    // Swiper initialization
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
