@php
    $coverUrl = $collection->cover_image
        ? (\Illuminate\Support\Str::startsWith($collection->cover_image, ['http://', 'https://'])
            ? $collection->cover_image
            : asset('storage/' . $collection->cover_image))
        : null;

    $description = $collection->description
        ? \Illuminate\Support\Str::limit(strip_tags($collection->description), 140)
        : 'Coleção ainda sem descrição. Clique para descobrir os jogos.';

    $gamesTotal = $collection->games_count ?? ($collection->games->count() ?? 0);
    $followersTotal = $collection->followers_count ?? ($collection->followers->count() ?? 0);
    $ownerName = optional($collection->user)->name ?? 'MemoryCard';

    $highlightLabel = $highlightLabel ?? null;
    $highlightIcon = $highlightIcon ?? 'fa-star';
    $highlightVariant = $highlightVariant ?? 'primary';
@endphp

<article class="collection-card {{ isset($cardVariant) ? 'collection-card-' . $cardVariant : '' }}">
    <div class="collection-cover">
        @if($coverUrl)
            <img src="{{ $coverUrl }}" alt="{{ $collection->name }}">
        @else
            <div class="collection-cover-fallback">
                <i class="fas fa-layer-group"></i>
            </div>
        @endif

        <span class="collection-privacy {{ $collection->is_public ? 'public' : 'private' }}">
            <i class="fas {{ $collection->is_public ? 'fa-globe' : 'fa-lock' }}"></i>
            {{ $collection->is_public ? 'Pública' : 'Privada' }}
        </span>

        @if($highlightLabel)
            <span class="collection-highlight collection-highlight-{{ $highlightVariant }}">
                <i class="fas {{ $highlightIcon }} me-1"></i>{{ $highlightLabel }}
            </span>
        @endif
    </div>

    <div class="collection-card-body">
        <div class="collection-card-header">
            <div>
                <h3 class="collection-card-title">{{ $collection->name }}</h3>
                <div class="collection-owner">
                    <i class="fas fa-user-circle me-1"></i>{{ $ownerName }}
                </div>
            </div>
            <span class="collection-updated">
                <i class="fas fa-clock me-1"></i>
                {{ $collection->updated_at ? $collection->updated_at->diffForHumans() : 'Atualizada recentemente' }}
            </span>
        </div>

        <p class="collection-description">{{ $description }}</p>

        @if($collection->tags && $collection->tags->count() > 0)
            <div class="collection-tags">
                @foreach($collection->tags->take(3) as $tag)
                    <a href="{{ route('collections.index', ['tag' => $tag->slug]) }}" class="collection-tag">
                        <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="collection-card-meta">
            <div class="meta-item">
                <span class="meta-icon">
                    <i class="fas fa-gamepad"></i>
                </span>
                <div>
                    <strong>{{ $gamesTotal }}</strong>
                    <small>{{ $gamesTotal === 1 ? 'Jogo' : 'Jogos' }}</small>
                </div>
            </div>
            <div class="meta-item">
                <span class="meta-icon">
                    <i class="fas fa-users"></i>
                </span>
                <div>
                    <strong>{{ $followersTotal }}</strong>
                    <small>{{ $followersTotal === 1 ? 'Seguidor' : 'Seguidores' }}</small>
                </div>
            </div>
        </div>

        <div class="collection-card-actions">
            <a href="{{ route('collections.show', $collection->slug) }}" class="btn btn-collection">
                <i class="fas fa-eye me-2"></i>Ver Coleção
            </a>
        </div>
    </div>
</article>
