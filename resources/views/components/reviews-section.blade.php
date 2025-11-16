@props(['game'])

@php
    $reviews = $game->reviews()->with('user')->orderBy('created_at', 'desc')->get();
    $totalReviews = $reviews->count();
    $averageRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
    $userReview = Auth::check() ? $reviews->where('user_id', Auth::id())->first() : null;
    
    $distribution = [
        5 => $reviews->where('rating', 5)->count(),
        4 => $reviews->where('rating', 4)->count(),
        3 => $reviews->where('rating', 3)->count(),
        2 => $reviews->where('rating', 2)->count(),
        1 => $reviews->where('rating', 1)->count(),
    ];
@endphp

<section class="reviews-section">
    <div class="reviews-header">
        <h3>
            <i class="fas fa-star"></i>
            Avaliações dos Jogadores
        </h3>
        
        @auth
            @if($userReview)
                <button type="button" class="btn-add-review" onclick='openEditReviewModal(@json($userReview))'>
                    <i class="fas fa-edit"></i>
                    Editar Minha Avaliação
                </button>
            @else
                <button type="button" class="btn-add-review" onclick="openReviewModal()">
                    <i class="fas fa-plus-circle"></i>
                    Adicionar Avaliação
                </button>
            @endif
        @else
            <a href="#" onclick="alert('Faça login para avaliar este jogo'); return false;" class="btn-add-review">
                <i class="fas fa-sign-in-alt"></i>
                Fazer Login para Avaliar
            </a>
        @endauth
    </div>

    @if($totalReviews > 0)
        <!-- Estatísticas -->
        <div class="reviews-stats">
            <div class="reviews-stats-rating">
                <div class="reviews-stats-rating-number">{{ number_format($averageRating, 1) }}</div>
                <div class="reviews-stats-rating-stars">
                    <x-star-rating :rating="$averageRating" size="lg" />
                </div>
                <div class="reviews-stats-rating-total">
                    {{ $totalReviews }} {{ $totalReviews === 1 ? 'avaliação' : 'avaliações' }}
                </div>
            </div>

            <div class="reviews-stats-distribution">
                @foreach([5,4,3,2,1] as $stars)
                    <div class="review-distribution-bar">
                        <div class="review-distribution-bar-label">
                            {{ $stars }} <i class="fas fa-star"></i>
                        </div>
                        <div class="review-distribution-bar-container">
                            <div class="review-distribution-bar-fill" 
                                 style="width: {{ $totalReviews > 0 ? ($distribution[$stars] / $totalReviews * 100) : 0 }}%">
                            </div>
                        </div>
                        <div class="review-distribution-bar-count">{{ $distribution[$stars] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Lista de Reviews -->
        <div class="reviews-list">
            @foreach($reviews as $review)
                <div class="review-card">
                    <div class="review-card-header">
                        <div class="review-card-user">
                            <div class="review-card-avatar">
                                @if($review->user->avatar)
                                    <img src="{{ asset($review->user->avatar) }}" alt="{{ $review->user->name }}">
                                @else
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="review-card-user-info">
                                <h4>{{ $review->user->name }}</h4>
                                <div class="review-card-meta">
                                    <div class="review-card-rating">
                                        <x-star-rating :rating="$review->rating" size="sm" />
                                    </div>
                                    <span>•</span>
                                    <span>{{ $review->created_at->diffForHumans() }}</span>
                                    @if($review->wasEdited())
                                        <span class="review-card-edited">
                                            (editado)
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @auth
                            @if(Auth::id() === $review->user_id || Auth::user()->type === 'adm')
                                <div class="review-card-actions">
                                    @if(Auth::id() === $review->user_id)
                                        <button class="review-card-action-btn" onclick='openEditReviewModal(@json($review))'>
                                            <i class="fas fa-edit"></i>
                                            Editar
                                        </button>
                                    @endif
                                    <button class="review-card-action-btn delete" onclick="deleteReview({{ $review->id }})">
                                        <i class="fas fa-trash"></i>
                                        Deletar
                                    </button>
                                </div>
                            @endif
                        @endauth
                    </div>

                    @if($review->review)
                        <div class="review-card-content">
                            @if($review->spoiler)
                                <div class="review-card-spoiler-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Este review contém spoilers. Clique para revelar.</span>
                                </div>
                                <p class="review-card-text review-card-spoiler-text" onclick="revealSpoiler(this)">
                                    {{ $review->review }}
                                </p>
                            @else
                                <p class="review-card-text">{{ $review->review }}</p>
                            @endif
                        </div>
                    @endif

                    @if($review->status || $review->hours_played || $review->played_at)
                        <div class="review-card-footer">
                            @if($review->status)
                                <div class="review-card-status">
                                    <span>{{ $review->status_label }}</span>
                                </div>
                            @endif

                            @if($review->hours_played)
                                <div class="review-card-status">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $review->hours_played }}h jogadas</span>
                                </div>
                            @endif

                            @if($review->played_at)
                                <div class="review-card-status">
                                    <i class="fas fa-calendar"></i>
                                    <span>Jogado em {{ $review->played_at->format('m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado Vazio -->
        <div class="reviews-empty">
            <div class="reviews-empty-icon">
                <i class="far fa-star"></i>
            </div>
            <h4 class="reviews-empty-title">Seja o primeiro a avaliar!</h4>
            <p class="reviews-empty-text">
                Ninguém avaliou este jogo ainda. Que tal ser o primeiro?
            </p>
            @auth
                <button type="button" class="btn-add-review" onclick="openReviewModal()">
                    <i class="fas fa-plus-circle"></i>
                    Adicionar Primeira Avaliação
                </button>
            @else
                <p class="text-muted">
                    <a href="#" onclick="alert('Faça login para avaliar'); return false;">Faça login</a> para avaliar este jogo
                </p>
            @endauth
        </div>
    @endif
</section>

