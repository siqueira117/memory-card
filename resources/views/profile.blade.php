@extends('layout')

@section('content')
<div class="container mt-5">
    <!-- User Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-dark-custom p-5 text-center position-relative overflow-hidden">
                <!-- Decorative background -->
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(45, 150, 27, 0.1) 0%, rgba(0, 0, 0, 0) 100%); z-index: 0;"></div>
                
                <div class="position-relative" style="z-index: 1;">
                    <div class="user-avatar mb-3">
                        <div class="avatar-circle">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="profile-avatar-img">
                            @else
                                <img src="{{ asset('img/default-avatar.png') }}" alt="{{ $user->name }}" class="profile-avatar-img">
                            @endif
                        </div>
                    </div>
                    <h2 class="fw-bold text-white mb-2">{{ $user->name }}</h2>
                    
                    @if($user->bio)
                        <p class="user-bio text-secondary mb-3">
                            <i class="fas fa-quote-left me-2"></i>{{ $user->bio }}
                        </p>
                    @endif
                    
                    <p class="text-secondary mb-0">
                        <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                    </p>
                    <p class="text-secondary mb-3">
                        <i class="fas fa-calendar me-2"></i>Membro desde {{ $user->created_at->format('d/m/Y') }}
                    </p>
                    
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-custom btn-sm">
                        <i class="fas fa-edit me-2"></i>Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4 g-3">
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-dark-custom p-3 text-center h-100">
                <i class="fas fa-gamepad fa-2x text-success mb-2"></i>
                <h3 class="stat-number">{{ $stats['total_games'] }}</h3>
                <p class="stat-label mb-0">Total de Jogos</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-dark-custom p-3 text-center h-100">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3 class="stat-number">{{ $stats['played'] }}</h3>
                <p class="stat-label mb-0">Jogados</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-dark-custom p-3 text-center h-100">
                <i class="fas fa-play-circle fa-2x text-warning mb-2"></i>
                <h3 class="stat-number">{{ $stats['playing'] }}</h3>
                <p class="stat-label mb-0">Jogando</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-dark-custom p-3 text-center h-100">
                <i class="fas fa-book fa-2x text-info mb-2"></i>
                <h3 class="stat-number">{{ $stats['backlog'] }}</h3>
                <p class="stat-label mb-0">Backlog</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-dark-custom p-3 text-center h-100">
                <i class="fas fa-gift fa-2x text-danger mb-2"></i>
                <h3 class="stat-number">{{ $stats['wishlist'] }}</h3>
                <p class="stat-label mb-0">Wishlist</p>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-dark-custom p-3 text-center h-100">
                <i class="fas fa-star fa-2x text-warning mb-2"></i>
                <h3 class="stat-number">{{ $stats['total_reviews'] }}</h3>
                <p class="stat-label mb-0">Reviews</p>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="playing-tab" data-bs-toggle="tab" data-bs-target="#playing" type="button">
                <i class="fas fa-play me-2"></i>Jogando ({{ $stats['playing'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="played-tab" data-bs-toggle="tab" data-bs-target="#played" type="button">
                <i class="fas fa-gamepad me-2"></i>Jogados ({{ $stats['played'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="backlog-tab" data-bs-toggle="tab" data-bs-target="#backlog" type="button">
                <i class="fas fa-book me-2"></i>Backlog ({{ $stats['backlog'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="wishlist-tab" data-bs-toggle="tab" data-bs-target="#wishlist" type="button">
                <i class="fas fa-gift me-2"></i>Wishlist ({{ $stats['wishlist'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button">
                <i class="fas fa-star me-2"></i>Minhas Reviews
            </button>
        </li>
    </ul>

    <!-- Tabs Content -->
    <div class="tab-content" id="profileTabsContent">
        <!-- Playing Tab -->
        <div class="tab-pane fade show active" id="playing" role="tabpanel">
            @if($playingGames->count() > 0)
                <div class="row g-3">
                    @foreach($playingGames as $userGame)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <x-card-game-unique :game="$userGame->game" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-gamepad fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary">Você não está jogando nenhum jogo no momento.</p>
                </div>
            @endif
        </div>

        <!-- Played Tab -->
        <div class="tab-pane fade" id="played" role="tabpanel">
            @if($playedGames->count() > 0)
                <div class="row g-3">
                    @foreach($playedGames as $userGame)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <x-card-game-unique :game="$userGame->game" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-gamepad fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary">Você ainda não marcou nenhum jogo como jogado.</p>
                </div>
            @endif
        </div>

        <!-- Backlog Tab -->
        <div class="tab-pane fade" id="backlog" role="tabpanel">
            @if($backlogGames->count() > 0)
                <div class="row g-3">
                    @foreach($backlogGames as $userGame)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <x-card-game-unique :game="$userGame->game" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary">Seu backlog está vazio.</p>
                </div>
            @endif
        </div>

        <!-- Wishlist Tab -->
        <div class="tab-pane fade" id="wishlist" role="tabpanel">
            @if($wishlistGames->count() > 0)
                <div class="row g-3">
                    @foreach($wishlistGames as $userGame)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
                            <x-card-game-unique :game="$userGame->game" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-gift fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary">Sua wishlist está vazia.</p>
                </div>
            @endif
        </div>

        <!-- Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            @if($reviews->count() > 0)
                <div class="row g-3">
                    @foreach($reviews as $review)
                        <div class="col-12">
                            <div class="bg-dark-custom p-4">
                                <div class="d-flex align-items-start">
                                    <img src="{{ $review->game->coverUrl }}" alt="{{ $review->game->name }}" class="rounded me-3" style="width: 80px; height: 120px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h5 class="text-white mb-2">
                                            <a href="{{ route('game.details', $review->game->slug) }}" class="text-white text-decoration-none">
                                                {{ $review->game->name }}
                                            </a>
                                        </h5>
                                        <div class="mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $review->rating >= $i ? 'text-warning' : 'text-secondary' }}"></i>
                                            @endfor
                                            <span class="text-secondary ms-2">{{ $review->rating }}/5</span>
                                        </div>
                                        <p class="text-secondary mb-2">{{ $review->review }}</p>
                                        <small class="text-secondary">
                                            <i class="far fa-clock me-1"></i>{{ $review->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-star fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary">Você ainda não fez nenhuma review.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 150px;
    height: 150px;
    background: var(--card-gradient);
    border: 4px solid var(--btn-color);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(45, 150, 27, 0.3);
    overflow: hidden;
}

.profile-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-bio {
    max-width: 600px;
    margin: 0 auto;
    font-style: italic;
    font-size: 1.05rem;
    line-height: 1.6;
}

.stat-card {
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.stat-card:hover {
    transform: translateY(-5px);
    border-color: var(--btn-color);
    box-shadow: 0 8px 24px rgba(45, 150, 27, 0.2);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 10px 0 5px 0;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.nav-tabs {
    border-bottom: 2px solid var(--border-color);
}

.nav-tabs .nav-link {
    color: var(--text-secondary);
    border: none;
    padding: 12px 20px;
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
}

.nav-tabs .nav-link:hover {
    color: var(--btn-color);
    border-bottom-color: var(--btn-color);
}

.nav-tabs .nav-link.active {
    color: var(--btn-color);
    background: transparent;
    border-bottom-color: var(--btn-color);
}
</style>
@endsection

