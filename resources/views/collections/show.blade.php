@extends('layout')

@section('title', $collection->name . ' - MemoryCard')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="card bg-dark border-success mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-layer-group fa-2x text-white"></i>
                        </div>
                        <div>
                            <h1 class="h2 text-white mb-2">{{ $collection->name }}</h1>
                            <span class="badge {{ $collection->is_public ? 'bg-success' : 'bg-warning text-dark' }}">
                                <i class="fas {{ $collection->is_public ? 'fa-globe' : 'fa-lock' }}"></i>
                                {{ $collection->is_public ? 'Pública' : 'Privada' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($collection->description)
                    <p class="text-secondary mb-3">{{ $collection->description }}</p>
                    @endif

                    @if($collection->tags && $collection->tags->count() > 0)
                    <div class="mb-3">
                        @foreach($collection->tags as $tag)
                        <a href="{{ route('collections.index', ['tag' => $tag->slug]) }}" class="badge bg-secondary text-decoration-none me-1">
                            <i class="fas fa-tag"></i> {{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <div class="d-flex flex-wrap gap-3 text-secondary">
                        @if($collection->user)
                        <span>
                            <i class="fas fa-user text-success"></i>
                            {{ $collection->user->name }}
                        </span>
                        @endif
                        <span>
                            <i class="fas fa-gamepad text-success"></i>
                            <strong>{{ $collection->games_count }}</strong> {{ $collection->games_count === 1 ? 'jogo' : 'jogos' }}
                        </span>
                        <span>
                            <i class="fas fa-users text-success"></i>
                            <strong id="followersCount">{{ $collection->followers_count }}</strong> {{ $collection->followers_count === 1 ? 'seguidor' : 'seguidores' }}
                        </span>
                    </div>
                </div>

                <div class="col-md-4 mt-3 mt-md-0">
                    @auth
                        @if($isOwner)
                            <div class="d-grid gap-2">
                                <a href="{{ route('collections.edit', $collection->slug) }}" class="btn btn-success">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <div class="btn-group">
                                    <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-download"></i> Exportar
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('collections.export.json', $collection->slug) }}">
                                                <i class="fas fa-file-code"></i> JSON
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('collections.export.csv', $collection->slug) }}">
                                                <i class="fas fa-file-csv"></i> CSV
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <button 
                                id="followBtn" 
                                class="btn {{ $isFollowing ? 'btn-success' : 'btn-outline-success' }} w-100"
                                onclick="toggleFollow()"
                            >
                                <i class="fas fa-heart"></i>
                                <span id="followText">{{ $isFollowing ? 'Seguindo' : 'Seguir' }}</span>
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Jogos -->
    @if($collection->games && $collection->games->count() > 0)
    <h3 class="text-white mb-4">
        <i class="fas fa-gamepad text-success"></i> Jogos da Coleção
    </h3>

    <div class="row g-4">
        @foreach($collection->games as $game)
        <div class="col-md-6 col-lg-4">
            <x-card-game-unique :game="$game" />
            
            @if($isOwner)
            <div class="mt-2">
                <button 
                    class="btn btn-sm btn-outline-danger w-100"
                    onclick="removeGame({{ $game->game_id }})"
                >
                    <i class="fas fa-trash"></i> Remover da Coleção
                </button>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <i class="fas fa-gamepad fa-5x text-secondary mb-3"></i>
        <h3 class="text-white">Nenhum jogo nesta coleção</h3>
        @if($isOwner)
        <p class="text-secondary">Adicione jogos visitando a página de detalhes de qualquer jogo!</p>
        <a href="{{ route('index') }}" class="btn btn-success mt-3">
            <i class="fas fa-search"></i> Explorar Jogos
        </a>
        @endif
    </div>
    @endif

    <!-- Voltar -->
    <div class="mt-5">
        <a href="{{ route('collections.index') }}" class="btn btn-outline-success">
            <i class="fas fa-arrow-left"></i> Voltar para Coleções
        </a>
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
                btn.classList.remove('btn-outline-success');
                btn.classList.add('btn-success');
            } else {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-success');
            }

            text.textContent = data.action === 'followed' ? 'Seguindo' : 'Seguir';
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
