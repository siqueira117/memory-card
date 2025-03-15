<div>
    <div class="d-flex mb-3">
        <input wire:model.live="search" type="text" id="search" class="search-bar w-100" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Pesquisar jogos...">
        @auth
            @if( Auth::user()->type === 'adm' )
                <button class="btn btn-custom ms-2 w-20" data-bs-toggle="modal" data-bs-target="#gameModal">Add game</button>
                <button class="btn btn-custom ms-2 w-20" data-bs-toggle="modal" data-bs-target="#gameManualModal">Add manual</button>
            @endif
        @endauth
    </div>
    <!-- Filtros -->
    <div class="d-flex mb-3">
        <select class="me-2 form-select select-black" wire:model="genre">
            <option value="" selected>Todos os gêneros</option>
            @foreach($genres as $genre)
                <option value="{{ $genre['genre_id'] }}">{{ $genre['name'] }}</option>
            @endforeach
        </select>
    
        <select class="me-2 form-select select-black" wire:model="platform">
            <option value="" selected>Todas as plataformas</option>
            @foreach($platforms as $platform)
                <option value="{{ $platform['platform_id'] }}">{{ $platform['name'] }}</option>
            @endforeach
        </select>
    
        <select class="me-2 form-select select-black" wire:model="orderBy">
            <option value="created_at" selected>Ordernar por Novidade</option>
            <option value="name">Ordenar por Nome</option>
            <option value="first_release_date">Ordenar por Data de Lançamento</option>
        </select>
    
        <button class="btn btn-custom ms-2" wire:click="$toggle('orderDirection')">
            {{ $orderDirection  ? '⬆️ Ascendente' : '⬇️ Descendente' }}
        </button>

        <button class="btn btn-custom ms-2" x-on:click="$wire.$refresh()">
            Filtrar
        </button>
    </div>

    <small>Total de jogos: {{ $allGames }}</small>

    <!-- Loading Spinner -->
    <div wire:loading wire:target="search, genre, platform, orderBy, orderDirection" class="text-center my-4 container">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <p>Carregando resultados...</p>
    </div>

    @if(sizeof($games) > 0)
        <div id="game-list" class="row justify-content-left mx-auto h-100 w-100" wire:loading.remove>
            <x-card-game :games="$games"/>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4 w-100">
            {{ $games->links('livewire.pagination') }}
        </div>
    @else
        <div class="justify-content-center w-100 h-100" style="margin-top: 30vh; margin-bottom: 30vh" wire:loading.remove>
            <h4 class="text-center h-100">Não foi possível encontrar seu jogo! :(</h4>
        </div>
    @endif
</div>