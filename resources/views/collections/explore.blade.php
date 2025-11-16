@extends('layout')

@section('title', 'Explorar Coleções')

@section('style')
<link rel="stylesheet" href="{{ asset('css/collections.css') }}">
@endsection

@section('content')
<div class="collections-page py-5">
    <div class="container">
        <!-- Hero -->
        <div class="collections-hero glass-panel explore-hero mb-4">
            <div class="hero-content">
                <div class="hero-icon hero-icon-xl">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <p class="hero-eyebrow">Descubra novas curadorias</p>
                    <h1 class="hero-title">Explorar Coleções</h1>
                    <p class="hero-text">
                        Viaje pelas listas mais criativas da comunidade, encontre inspirações e siga curadores que combinam com o seu estilo de jogo.
                    </p>
                </div>
            </div>
            <div class="hero-metrics">
                <div class="hero-stat">
                    <span>Total de coleções</span>
                    <strong>{{ number_format($stats['total_collections']) }}</strong>
                    <small>Coleções públicas</small>
                </div>
                <div class="hero-stat">
                    <span>Jogos catalogados</span>
                    <strong>{{ number_format($stats['total_games']) }}</strong>
                    <small>Títulos diferentes</small>
                </div>
                <div class="hero-stat">
                    <span>Curadores ativos</span>
                    <strong>{{ number_format($stats['total_users']) }}</strong>
                    <small>Jogadores criadores</small>
                </div>
            </div>
        </div>

        @if($featured->count() > 0)
            <section class="collection-section mb-5">
                <div class="collection-section-header">
                    <div>
                        <p class="eyebrow">Seleção editorial</p>
                        <h2>Em destaque</h2>
                    </div>
                    <a href="{{ route('collections.index', ['sort' => 'popular']) }}" class="btn btn-custom-outline">
                        Ver todas <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="collection-grid collection-grid-featured">
                    @foreach($featured as $collection)
                        @include('collections.partials.card', [
                            'collection' => $collection,
                            'highlightLabel' => 'Em destaque',
                            'highlightIcon' => 'fa-star',
                            'highlightVariant' => 'featured',
                            'cardVariant' => 'featured'
                        ])
                    @endforeach
                </div>
            </section>
        @endif

        <section class="collection-section grid-two-columns mb-5">
            @if($popular->count() > 0)
                <div class="collection-column">
                    <div class="collection-section-header">
                        <div>
                            <p class="eyebrow">Tendências</p>
                            <h3>Coleções populares</h3>
                        </div>
                        <span class="section-subtitle">Mais seguidas pela comunidade</span>
                    </div>
                    <div class="collection-list">
                        @foreach($popular as $collection)
                            @include('collections.partials.card', [
                                'collection' => $collection,
                                'highlightLabel' => 'Popular',
                                'highlightIcon' => 'fa-fire',
                                'highlightVariant' => 'accent'
                            ])
                        @endforeach
                    </div>
                </div>
            @endif

            @if($recent->count() > 0)
                <div class="collection-column">
                    <div class="collection-section-header">
                        <div>
                            <p class="eyebrow">Quentinho no feed</p>
                            <h3>Chegaram agora</h3>
                        </div>
                        <span class="section-subtitle">Novas curadorias para seguir</span>
                    </div>
                    <div class="collection-list">
                        @foreach($recent as $collection)
                            @include('collections.partials.card', [
                                'collection' => $collection,
                                'highlightLabel' => 'Recente',
                                'highlightIcon' => 'fa-clock',
                                'highlightVariant' => 'neutral'
                            ])
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <section class="collection-section mb-5">
            <div class="collections-tags-card glass-panel mb-4">
                <div class="tags-header">
                    <div>
                        <p class="eyebrow">Explore por tema</p>
                        <h5>Tags mais buscadas</h5>
                    </div>
                    <a href="{{ route('collections.index') }}" class="btn btn-ghost">
                        Ver catálogo completo
                    </a>
                </div>
                <div class="tags-body">
                    @foreach($popularTags as $popularTag)
                        <a href="{{ route('collections.index', ['tag' => $popularTag->slug]) }}" class="tag-chip">
                            <span>{{ $popularTag->name }}</span>
                            <small>{{ $popularTag->usage_count }}</small>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="collection-callout glass-panel">
                <div>
                    <h4>Crie a sua coleção</h4>
                    <p>Tem uma ideia genial? Monte sua lista personalizada e convide amigos para seguir.</p>
                </div>
                @auth
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#newCollectionModal">
                        <i class="fas fa-plus me-2"></i>Nova Coleção
                    </button>
                @else
                    <a href="{{ route('login') }}" class="btn btn-custom">
                        <i class="fas fa-user-plus me-2"></i>Entre para criar
                    </a>
                @endauth
            </div>
        </section>
    </div>
</div>
@endsection
