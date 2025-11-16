@extends('layout')

@section('title', 'Coleções - MemoryCard')

@section('style')
<link rel="stylesheet" href="{{ asset('css/collections.css') }}">
@endsection

@section('content')
@php
    $filterLabels = [
        'public' => 'Coleções Públicas',
        'my' => 'Minhas Coleções',
        'following' => 'Coleções que sigo',
    ];

    $sortLabels = [
        'popular' => 'Populares',
        'recent' => 'Mais recentes',
        'name' => 'Ordem alfabética',
        'games' => 'Com mais jogos',
    ];

    $currentFilter = $filterLabels[$filter ?? 'public'] ?? $filterLabels['public'];
    $currentSort = $sortLabels[$sort ?? 'popular'] ?? $sortLabels['popular'];
@endphp

<div class="collections-page py-5">
    <div class="container">
        <!-- Hero -->
        <div class="collections-hero glass-panel mb-4">
            <div class="hero-content">
                <div class="hero-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <p class="hero-eyebrow">Comunidade MemoryCard</p>
                    <h1 class="hero-title">Coleções curadas para todos os estilos</h1>
                    <p class="hero-text">
                        Explore listas criadas pelos jogadores, descubra combinações incríveis de jogos e compartilhe a sua coleção com a comunidade.
                    </p>
                </div>
            </div>
            <div class="hero-details">
                <div class="hero-stat">
                    <span>Resultados</span>
                    <strong>{{ number_format($collections->total()) }}</strong>
                    <small>Coleções encontradas</small>
                </div>
                <div class="hero-stat">
                    <span>Filtro</span>
                    <strong>{{ $currentFilter }}</strong>
                    <small>Ordenadas por {{ $currentSort }}</small>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('collections.explore') }}" class="btn btn-custom-outline">
                        <i class="fas fa-compass me-2"></i>Explorar curadoria
                    </a>
                    @auth
                        <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                            <i class="fas fa-plus me-2"></i>Nova Coleção
                        </button>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="collections-search glass-panel mb-4">
            <form class="collections-search-form" action="{{ route('collections.index') }}" method="GET">
                <input type="hidden" name="filter" value="{{ $filter ?? 'public' }}">
                <input type="hidden" name="sort" value="{{ $sort ?? 'popular' }}">
                <input type="hidden" name="tag" value="{{ $tag ?? '' }}">

                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search ?? '' }}" 
                        placeholder="Buscar coleções, descrições ou jogos..."
                    >
                </div>
                <div class="search-actions">
                    @if(!empty($search))
                        <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => $sort ?? 'popular']) }}" class="btn btn-ghost">
                            <i class="fas fa-times me-1"></i>Limpar
                        </a>
                    @endif
                    <button type="submit" class="btn btn-custom">
                        <i class="fas fa-search me-2"></i>Pesquisar
                    </button>
                </div>
            </form>
        </div>

        <!-- Controls -->
        <div class="collections-controls mb-4">
            <div class="collections-filters">
                <a href="{{ route('collections.index', ['filter' => 'public', 'sort' => $sort ?? 'popular', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                   class="filter-pill {{ ($filter ?? 'public') === 'public' ? 'active' : '' }}">
                    <i class="fas fa-globe me-1"></i>Públicas
                </a>
                @auth
                    <a href="{{ route('collections.index', ['filter' => 'my', 'sort' => $sort ?? 'popular', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                       class="filter-pill {{ ($filter ?? 'public') === 'my' ? 'active' : '' }}">
                        <i class="fas fa-user me-1"></i>Minhas
                    </a>
                    <a href="{{ route('collections.index', ['filter' => 'following', 'sort' => $sort ?? 'popular', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                       class="filter-pill {{ ($filter ?? 'public') === 'following' ? 'active' : '' }}">
                        <i class="fas fa-heart me-1"></i>Seguindo
                    </a>
                @endauth
            </div>

            <div class="collections-sort">
                <span class="sort-label"><i class="fas fa-sliders-h me-2"></i>Ordenar por</span>
                <div class="sort-group">
                    <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'popular', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                       class="sort-pill {{ ($sort ?? 'popular') === 'popular' ? 'active' : '' }}">
                        Popularidade
                    </a>
                    <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'recent', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                       class="sort-pill {{ ($sort ?? 'popular') === 'recent' ? 'active' : '' }}">
                        Recentes
                    </a>
                    <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'name', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                       class="sort-pill {{ ($sort ?? 'popular') === 'name' ? 'active' : '' }}">
                        A-Z
                    </a>
                    <a href="{{ route('collections.index', ['filter' => $filter ?? 'public', 'sort' => 'games', 'tag' => $tag ?? null, 'search' => $search ?? null]) }}"
                       class="sort-pill {{ ($sort ?? 'popular') === 'games' ? 'active' : '' }}">
                        Mais jogos
                    </a>
                </div>
            </div>
        </div>

        <!-- Tags -->
        @if(isset($popularTags) && $popularTags->count() > 0)
            <div class="collections-tags-card glass-panel mb-4">
                <div class="tags-header">
                    <div>
                        <p class="eyebrow">Tags populares</p>
                        <h5>Descubra coleções por tema</h5>
                    </div>
                    @if(!empty($tag))
                        <a href="{{ route('collections.index', array_filter([
                            'filter' => $filter ?? 'public',
                            'sort' => $sort ?? 'popular',
                            'search' => $search ?? null,
                        ])) }}" class="btn btn-ghost">
                            <i class="fas fa-times me-1"></i>Limpar filtro
                        </a>
                    @endif
                </div>
                <div class="tags-body">
                    @foreach($popularTags as $popularTag)
                        <a href="{{ route('collections.index', array_filter([
                            'filter' => $filter ?? 'public',
                            'sort' => $sort ?? 'popular',
                            'tag' => $popularTag->slug,
                            'search' => $search ?? null,
                        ])) }}" class="tag-chip {{ ($tag ?? '') === $popularTag->slug ? 'active' : '' }}">
                            <span>{{ $popularTag->name }}</span>
                            <small>{{ $popularTag->usage_count }}</small>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Collection list -->
        @if($collections->count() > 0)
            <div class="collection-grid">
                @foreach($collections as $collection)
                    @include('collections.partials.card', ['collection' => $collection])
                @endforeach
            </div>

            <div class="collection-pagination">
                {{ $collections->links() }}
            </div>
        @else
            <div class="collections-empty glass-panel text-center">
                <div class="empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3>Nenhuma coleção encontrada</h3>
                @if(!empty($search))
                    <p>Não encontramos resultados para “{{ $search }}”. Ajuste os filtros para continuar explorando.</p>
                    <a href="{{ route('collections.index') }}" class="btn btn-custom-outline">
                        <i class="fas fa-undo me-2"></i>Resetar pesquisa
                    </a>
                @else
                    <p>Seja o primeiro a criar uma lista personalizada com seus jogos favoritos.</p>
                    @auth
                        <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                            <i class="fas fa-plus me-2"></i>Criar primeira coleção
                        </button>
                    @endauth
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
