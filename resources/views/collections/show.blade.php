@extends('layout')

@section('title', $collection->name . ' - MemoryCard')

@section('style')
<link rel="stylesheet" href="{{ asset('css/collections.css') }}">
@endsection

@section('content')
@php
    $coverUrl = $collection->cover_image
        ? (\Illuminate\Support\Str::startsWith($collection->cover_image, ['http://', 'https://'])
            ? $collection->cover_image
            : asset('storage/' . $collection->cover_image))
        : null;

    $gamesTotal = $collection->games_count ?? ($collection->games->count() ?? 0);
@endphp

<div class="collections-page py-5">
    <div class="container">
        <div class="collection-banner mb-4" style="{{ $coverUrl ? 'background-image: linear-gradient(135deg, rgba(15,15,18,0.95), rgba(15,15,18,0.7)), url(' . $coverUrl . ');' : '' }}">
            <div class="collection-banner-content">
                <div class="collection-banner-info">
                    <div class="collection-banner-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div>
                        <p class="eyebrow">Coleção</p>
                        <h1>{{ $collection->name }}</h1>
                        <div class="collection-badges">
                            <span class="badge badge-pill {{ $collection->is_public ? 'badge-public' : 'badge-private' }}">
                                <i class="fas {{ $collection->is_public ? 'fa-globe' : 'fa-lock' }}"></i>
                                {{ $collection->is_public ? 'Pública' : 'Privada' }}
                            </span>
                            @if($collection->user)
                                <span class="badge badge-pill badge-owner">
                                    <i class="fas fa-user-circle me-1"></i>{{ $collection->user->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @if($collection->description)
                    <p class="collection-banner-description">{{ $collection->description }}</p>
                @endif
                @if($collection->tags && $collection->tags->count() > 0)
                    <div class="collection-banner-tags">
                        @foreach($collection->tags as $tag)
                            <a href="{{ route('collections.index', ['tag' => $tag->slug]) }}" class="collection-tag">
                                <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="collection-banner-stats">
                <div class="hero-stat">
                    <span>Jogos</span>
                    <strong>{{ $gamesTotal }}</strong>
                    <small>{{ $gamesTotal === 1 ? 'Jogo' : 'Jogos' }} na lista</small>
                </div>
                <div class="hero-stat">
                    <span>Seguidores</span>
                    <strong id="followersCount">{{ $collection->followers_count }}</strong>
                    <small>{{ $collection->followers_count === 1 ? 'Seguidor' : 'Seguidores' }}</small>
                </div>
                <div class="hero-stat">
                    <span>Atualização</span>
                    <strong>{{ $collection->updated_at?->diffForHumans() ?? 'Agora há pouco' }}</strong>
                    <small>Última edição</small>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="collection-section-header mb-3">
                    <div>
                        <p class="eyebrow">Biblioteca</p>
                        <h2>Jogos da coleção</h2>
                    </div>
                    @if($isOwner)
                        <span class="section-subtitle">Adicione jogos pela página de detalhes.</span>
                    @endif
                </div>

                @if($collection->games && $collection->games->count() > 0)
                    <div class="collection-games-grid">
                        @foreach($collection->games as $game)
                            <div class="collection-game-card">
                                <x-card-game-unique :game="$game" />
                                @if($isOwner)
                                    <button 
                                        class="btn btn-ghost-danger" 
                                        onclick="removeGame({{ $game->game_id }})"
                                    >
                                        <i class="fas fa-trash me-2"></i>Remover da coleção
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="collections-empty glass-panel text-center">
                        <div class="empty-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h3>Esta coleção está vazia</h3>
                        @if($isOwner)
                            <p>Adicione jogos acessando a página de qualquer título no MemoryCard.</p>
                            <a href="{{ route('index') }}" class="btn btn-custom">
                                <i class="fas fa-search me-2"></i>Explorar jogos
                            </a>
                        @else
                            <p>O criador ainda não adicionou jogos aqui. Volte em breve!</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="collection-actions-card glass-panel mb-4">
                    <h5>Ações</h5>
                    @auth
                        @if($isOwner)
                            <a href="{{ route('collections.edit', $collection->slug) }}" class="btn btn-custom w-100 mb-2">
                                <i class="fas fa-edit me-2"></i>Editar coleção
                            </a>
                            <div class="dropdown w-100">
                                <button class="btn btn-custom-outline w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-download me-2"></i>Exportar jogos
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark w-100">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('collections.export.json', $collection->slug) }}">
                                            <i class="fas fa-file-code me-2"></i>JSON
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('collections.export.csv', $collection->slug) }}">
                                            <i class="fas fa-file-csv me-2"></i>CSV
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <button 
                                id="followBtn" 
                                class="btn {{ $isFollowing ? 'btn-custom' : 'btn-custom-outline' }} w-100"
                                onclick="toggleFollow()"
                            >
                                <i class="fas fa-heart me-2"></i>
                                <span id="followText">{{ $isFollowing ? 'Seguindo' : 'Seguir coleção' }}</span>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-custom w-100">
                            <i class="fas fa-user-plus me-2"></i>Entre para seguir
                        </a>
                    @endauth
                </div>

                <div class="collection-info-card glass-panel">
                    <h6>Detalhes rápidos</h6>
                    <ul>
                        <li>
                            <span>Criador</span>
                            <strong>{{ optional($collection->user)->name ?? 'Usuário desconhecido' }}</strong>
                        </li>
                        <li>
                            <span>Criada em</span>
                            <strong>{{ $collection->created_at?->format('d/m/Y') ?? '---' }}</strong>
                        </li>
                        <li>
                            <span>Visibilidade</span>
                            <strong>{{ $collection->is_public ? 'Pública' : 'Privada' }}</strong>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('collections.index') }}" class="btn btn-ghost w-100 mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Voltar para coleções
                </a>
            </div>
        </div>
    </div>
</div>

@auth
<script>
function toggleFollow() {
    fetch('{{ route("collections.follow", $collection->slug) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const btn = document.getElementById('followBtn');
            const text = document.getElementById('followText');
            const count = document.getElementById('followersCount');

            if (data.action === 'followed') {
                btn.classList.remove('btn-custom-outline');
                btn.classList.add('btn-custom');
            } else {
                btn.classList.remove('btn-custom');
                btn.classList.add('btn-custom-outline');
            }

            text.textContent = data.action === 'followed' ? 'Seguindo' : 'Seguir coleção';
            count.textContent = data.followers_count;

            showToast(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erro ao processar ação', 'error');
    });
}

@if($isOwner)
function removeGame(gameId) {
    if (!confirm('Deseja remover este jogo da coleção?')) {
        return;
    }

    fetch('{{ route("collections.remove-game") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            collection_id: {{ $collection->collection_id }},
            game_id: gameId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast(data.message || 'Erro ao remover jogo', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Erro ao remover jogo', 'error');
    });
}
@endif

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed bottom-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endauth
@endsection
