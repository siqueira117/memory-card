<div>
    <div class="d-flex mb-3">
        <input wire:model.live="search" type="text" id="search" class="search-bar w-80" placeholder="Pesquisar jogos...">
    
        @if( Route::is('masterchief') )
            <button class="btn btn-custom ms-2 w-20" data-bs-toggle="modal" data-bs-target="#gameModal">Add game</button>
        @endif
    </div>
    
    <div id="game-list" class="row justify-content-left">
        @if(sizeof($games) > 0)
            <x-card-game :games="$games" :platforms="$platforms" />
        @endif
    </div>
</div>