<div>
    <div class="d-flex mb-3">
        <input wire:model.live="search" type="text" id="search" class="search-bar w-100" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Pesquisar jogos...">
        @if( Route::is('masterchief') )
            <button class="btn btn-custom ms-2 w-20" data-bs-toggle="modal" data-bs-target="#gameModal">Add game</button>
        @endif
    </div>

    @if(sizeof($games) > 0)
        <div id="game-list" class="row justify-content-left mx-auto h-100 w-100">
            <x-card-game :games="$games" :platforms="$platforms" />
        </div>
    @else
        <div class="justify-content-center w-100 h-100" style="margin-top: 30vh; margin-bottom: 30vh">
            <h4 class="text-center h-100">Não foi possível encontrar seu jogo! :(</h4>
        </div>
    @endif
</div>