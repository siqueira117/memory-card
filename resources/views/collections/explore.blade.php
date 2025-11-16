@extends('layout')

@section('title', 'Explorar Coleções')

@section('content')
<div class="container py-5">
    <!-- Hero -->
    <div class="text-center mb-5">
        <div class="mb-3">
            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-gradient rounded-circle" style="width: 100px; height: 100px;">
                <i class="fas fa-compass fa-4x text-white"></i>
            </div>
        </div>
        <h1 class="display-3 fw-bold mb-3 text-white">
            Explorar Coleções
        </h1>
        <p class="lead text-secondary mb-4">Descubra listas incríveis criadas pela comunidade</p>
        
        <!-- Estatísticas -->
        <div class="row g-3 justify-content-center">
            <div class="col-auto">
                <div class="card bg-dark border-success">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-0">{{ number_format($stats['total_collections']) }}</h3>
                        <small class="text-secondary">Coleções</small>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card bg-dark border-success">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-0">{{ number_format($stats['total_games']) }}</h3>
                        <small class="text-secondary">Jogos</small>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="card bg-dark border-success">
                    <div class="card-body text-center">
                        <h3 class="text-success mb-0">{{ number_format($stats['total_users']) }}</h3>
                        <small class="text-secondary">Criadores</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Em Destaque -->
    @if($featured->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white mb-0">
                <i class="fas fa-star text-warning"></i> Em Destaque
            </h2>
            <a href="{{ route('collections.index', ['sort' => 'popular']) }}" class="btn btn-outline-success">
                Ver Todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featured->take(6) as $collection)
            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark h-100 border-0 shadow-lg">
                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                        @if($collection->cover_image)
                            <img src="{{ str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/' . $collection->cover_image) }}" 
                                 class="card-img-top w-100 h-100" 
                                 style="object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary h-100">
                                <i class="fas fa-layer-group fa-4x text-muted"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-warning text-dark" style="padding: 8px 12px;">
                            <i class="fas fa-star me-1"></i> Destaque
                        </span>
                    </div>

                    <div class="card-body pb-2">
                        <h5 class="card-title text-white fw-bold mb-3">
                            <a href="{{ route('collections.show', $collection->slug) }}" class="text-white text-decoration-none">
                                {{ $collection->name }}
                            </a>
                        </h5>

                        <div class="d-flex justify-content-between align-items-center text-muted">
                            <span class="d-flex align-items-center">
                                <i class="fas fa-gamepad text-success me-2"></i>
                                <strong class="text-white">{{ $collection->games_count }}</strong>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fas fa-users text-success me-2"></i>
                                <strong class="text-white">{{ $collection->followers_count }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                        <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-outline-warning w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-eye me-2"></i> Ver Coleção
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Tags Populares -->
    @if($popularTags->count() > 0)
    <section class="mb-5">
        <h2 class="text-white mb-4">
            <i class="fas fa-tags text-success"></i> Tags Populares
        </h2>

        <div class="row g-3">
            @foreach($popularTags as $tag)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('collections.index', ['tag' => $tag->slug]) }}" class="text-decoration-none">
                    <div class="card bg-dark border-success h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-success bg-gradient rounded p-3">
                                    <i class="fas fa-tag fa-2x text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="text-white mb-1">{{ $tag->name }}</h5>
                                    <small class="text-secondary">{{ $tag->usage_count }} {{ $tag->usage_count == 1 ? 'coleção' : 'coleções' }}</small>
                                </div>
                                <i class="fas fa-chevron-right text-success"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Populares -->
    @if($popular->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white mb-0">
                <i class="fas fa-fire text-danger"></i> Populares
            </h2>
            <a href="{{ route('collections.index', ['sort' => 'popular']) }}" class="btn btn-outline-success">
                Ver Todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($popular->take(4) as $collection)
            <div class="col-md-6">
                <div class="card bg-dark border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="col-5">
                            <div class="position-relative" style="height: 200px; overflow: hidden;">
                                @if($collection->cover_image)
                                    <img src="{{ str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/' . $collection->cover_image) }}" 
                                         class="w-100 h-100 rounded-start" 
                                         style="object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center bg-secondary h-100 rounded-start">
                                        <i class="fas fa-layer-group fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <span class="position-absolute top-0 start-0 m-2 badge rounded-pill bg-dark" style="padding: 6px 10px; font-size: 0.75rem;">
                                    <i class="fas fa-globe"></i> Pública
                                </span>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="card-body d-flex flex-column h-100">
                                <h5 class="card-title text-white fw-bold mb-2">
                                    <a href="{{ route('collections.show', $collection->slug) }}" class="text-white text-decoration-none">
                                        {{ Str::limit($collection->name, 40) }}
                                    </a>
                                </h5>
                                @if($collection->description)
                                <p class="card-text text-secondary small mb-3">{{ Str::limit($collection->description, 80) }}</p>
                                @endif
                                <div class="d-flex gap-3 text-muted mt-auto">
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-gamepad text-success me-1"></i> 
                                        <strong class="text-white">{{ $collection->games_count }}</strong>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-users text-success me-1"></i> 
                                        <strong class="text-white">{{ $collection->followers_count }}</strong>
                                    </span>
                                </div>
                                <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-outline-success btn-sm mt-3">
                                    <i class="fas fa-eye me-1"></i> Ver Coleção
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Recentes -->
    @if($recent->count() > 0)
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white mb-0">
                <i class="fas fa-clock text-info"></i> Recentes
            </h2>
            <a href="{{ route('collections.index', ['sort' => 'recent']) }}" class="btn btn-outline-success">
                Ver Todas <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="row g-3">
            @foreach($recent->take(8) as $collection)
            <div class="col-md-6 col-lg-3">
                <div class="card bg-dark h-100 border-0 shadow-sm">
                    <div class="position-relative" style="height: 150px; overflow: hidden;">
                        @if($collection->cover_image)
                            <img src="{{ str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/' . $collection->cover_image) }}" 
                                 class="card-img-top w-100 h-100" 
                                 style="object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-secondary h-100">
                                <i class="fas fa-layer-group fa-3x text-muted"></i>
                            </div>
                        @endif
                        <span class="position-absolute top-0 start-0 m-2 badge rounded-pill bg-dark" style="padding: 6px 10px; font-size: 0.75rem;">
                            <i class="fas fa-globe"></i> Pública
                        </span>
                    </div>

                    <div class="card-body pb-2">
                        <h6 class="card-title text-white fw-bold mb-2" style="font-size: 0.95rem;">
                            <a href="{{ route('collections.show', $collection->slug) }}" class="text-white text-decoration-none">
                                {{ Str::limit($collection->name, 35) }}
                            </a>
                        </h6>
                        <div class="d-flex justify-content-between text-muted" style="font-size: 0.85rem;">
                            <span><i class="fas fa-gamepad text-success me-1"></i> {{ $collection->games_count }}</span>
                            <span><i class="fas fa-users text-success me-1"></i> {{ $collection->followers_count }}</span>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-0 pt-0 pb-2">
                        <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-outline-success btn-sm w-100">
                            <i class="fas fa-eye me-1"></i> Ver Coleção
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- CTA -->
    <div class="text-center py-5 mt-5">
        <div class="card bg-success bg-gradient border-0">
            <div class="card-body py-5">
                <i class="fas fa-plus-circle fa-4x text-white mb-3"></i>
                <h3 class="text-white mb-3">Crie sua própria coleção</h3>
                <p class="text-white mb-4">Organize seus jogos favoritos e compartilhe com a comunidade</p>
                @auth
                <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                    <i class="fas fa-plus"></i> Criar Coleção
                </button>
                @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Entrar para Criar
                </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
