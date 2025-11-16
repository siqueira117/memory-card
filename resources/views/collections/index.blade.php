@extends('layout')

@section('title', 'Coleções - MemoryCard')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <div class="mb-3">
            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-gradient rounded-circle" style="width: 80px; height: 80px;">
                <i class="fas fa-layer-group fa-3x text-white"></i>
            </div>
        </div>
        <h1 class="display-4 fw-bold mb-3 text-white">
            Coleções de Jogos
        </h1>
        <p class="lead text-secondary">Organize e compartilhe suas listas de jogos favoritos</p>
    </div>

    <!-- Barra de Pesquisa -->
    <div class="mb-4">
        <form action="{{ route('collections.index') }}" method="GET">
            <input type="hidden" name="filter" value="{{ $filter ?? 'public' }}">
            <input type="hidden" name="sort" value="{{ $sort ?? 'popular' }}">
            <input type="hidden" name="tag" value="{{ $tag ?? '' }}">
            
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-dark border-secondary">
                    <i class="fas fa-search text-secondary"></i>
                </span>
                <input 
                    type="text" 
                    name="search" 
                    class="form-control bg-dark border-secondary text-white" 
                    placeholder="Pesquisar coleções..." 
                    value="{{ $search ?? '' }}"
                >
                @if(isset($search) && $search)
                <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => $sort ?? 'popular']) }}" 
                   class="btn btn-outline-danger">
                    <i class="fas fa-times"></i>
                </a>
                @endif
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-md-8 mb-3 mb-md-0">
            <div class="btn-group w-100" role="group">
                <a href="{{ route('collections.index', ['filter' => 'public']) }}" 
                   class="btn {{ ($filter ?? 'public') === 'public' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-globe"></i> Públicas
                </a>
                @auth
                <a href="{{ route('collections.index', ['filter' => 'my']) }}" 
                   class="btn {{ ($filter ?? 'public') === 'my' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-user"></i> Minhas
                </a>
                <a href="{{ route('collections.index', ['filter' => 'following']) }}" 
                   class="btn {{ ($filter ?? 'public') === 'following' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-heart"></i> Seguindo
                </a>
                @endauth
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex gap-2">
                <a href="{{ route('collections.explore') }}" class="btn btn-outline-success flex-fill">
                    <i class="fas fa-compass"></i> Explorar
                </a>
                @auth
                <button class="btn btn-success flex-fill" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                    <i class="fas fa-plus"></i> Nova Coleção
                </button>
                @endauth
            </div>
        </div>
    </div>

    <!-- Ordenação -->
    <div class="mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'popular']) }}" 
               class="btn btn-sm {{ ($sort ?? 'popular') === 'popular' ? 'btn-success' : 'btn-outline-secondary' }}">
                <i class="fas fa-fire"></i> Popular
            </a>
            <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'recent']) }}" 
               class="btn btn-sm {{ ($sort ?? 'popular') === 'recent' ? 'btn-success' : 'btn-outline-secondary' }}">
                <i class="fas fa-clock"></i> Recentes
            </a>
            <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'name']) }}" 
               class="btn btn-sm {{ ($sort ?? 'popular') === 'name' ? 'btn-success' : 'btn-outline-secondary' }}">
                <i class="fas fa-sort-alpha-down"></i> A-Z
            </a>
            <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'games']) }}" 
               class="btn btn-sm {{ ($sort ?? 'popular') === 'games' ? 'btn-success' : 'btn-outline-secondary' }}">
                <i class="fas fa-gamepad"></i> Jogos
            </a>
        </div>
    </div>

    <!-- Tags Populares -->
    @if(isset($popularTags) && $popularTags->count() > 0)
    <div class="card bg-dark border-secondary mb-4">
        <div class="card-body">
            <h6 class="card-title text-success mb-3">
                <i class="fas fa-tags"></i> Tags Populares
            </h6>
            <div class="d-flex flex-wrap gap-2">
                @foreach($popularTags as $popularTag)
                <a href="{{ route('collections.index', ['tag' => $popularTag->slug]) }}" 
                   class="badge {{ ($tag ?? '') === $popularTag->slug ? 'bg-success' : 'bg-secondary' }} text-decoration-none">
                    {{ $popularTag->name }}
                    <span class="badge bg-dark ms-1">{{ $popularTag->usage_count }}</span>
                </a>
                @endforeach
                @if(isset($tag) && $tag)
                <a href="{{ route('collections.index') }}" 
                   class="badge bg-danger text-decoration-none">
                    <i class="fas fa-times"></i> Limpar Filtro
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Lista de Coleções -->
    @if($collections->count() > 0)
    <div class="row g-4">
        @foreach($collections as $collection)
        <div class="col-md-6 col-lg-4">
            <div class="card bg-dark h-100 border-0 shadow-sm">
                <!-- Cover -->
                <div class="position-relative" style="height: 250px; overflow: hidden;">
                    @if($collection->cover_image)
                        <img src="{{ str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/' . $collection->cover_image) }}" 
                             class="card-img-top w-100 h-100" 
                             alt="{{ $collection->name }}"
                             style="object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-secondary h-100">
                            <i class="fas fa-layer-group fa-4x text-muted"></i>
                        </div>
                    @endif
                    
                    <!-- Badge Público/Privado -->
                    <span class="position-absolute top-0 start-0 m-3 badge rounded-pill {{ $collection->is_public ? 'bg-dark' : 'bg-warning text-dark' }}" style="padding: 8px 12px;">
                        <i class="fas {{ $collection->is_public ? 'fa-globe' : 'fa-lock' }} me-1"></i>
                        {{ $collection->is_public ? 'Pública' : 'Privada' }}
                    </span>
                </div>

                <!-- Body -->
                <div class="card-body pb-2">
                    <h5 class="card-title text-white fw-bold mb-3">
                        <a href="{{ route('collections.show', $collection->slug) }}" class="text-white text-decoration-none">
                            {{ $collection->name }}
                        </a>
                    </h5>

                    <!-- Stats -->
                    <div class="d-flex justify-content-between align-items-center text-muted">
                        <span class="d-flex align-items-center">
                            <i class="fas fa-gamepad text-success me-2"></i>
                            <strong class="text-white">{{ $collection->games_count }}</strong>
                            <span class="ms-1">{{ $collection->games_count === 1 ? 'jogo' : 'jogos' }}</span>
                        </span>
                        <span class="d-flex align-items-center">
                            <i class="fas fa-users text-success me-2"></i>
                            <strong class="text-white">{{ $collection->followers_count }}</strong>
                            <span class="ms-1">{{ $collection->followers_count === 1 ? 'seguidor' : 'seguidores' }}</span>
                        </span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-transparent border-0 pt-0 pb-3">
                    <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center">
                        <i class="fas fa-eye me-2"></i> Ver Coleção
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginação -->
    <div class="mt-4">
        {{ $collections->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-folder-open fa-5x text-secondary"></i>
        </div>
        <h3 class="text-white">Nenhuma coleção encontrada</h3>
        @if(isset($search) && $search)
        <p class="text-secondary">Não encontramos coleções com "{{ $search }}"</p>
        <a href="{{ route('collections.index') }}" class="btn btn-outline-success mt-3">
            <i class="fas fa-times"></i> Limpar Pesquisa
        </a>
        @else
        <p class="text-secondary">Seja o primeiro a criar uma coleção!</p>
        @auth
        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
            <i class="fas fa-plus"></i> Criar Primeira Coleção
        </button>
        @endauth
        @endif
    </div>
    @endif
</div>
@endsection
