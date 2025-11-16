<div class="card h-100 w-100">
    @php
        $created    = new DateTime($game["created_at"]);
        $today      = new DateTime();

        $dateInterval = $created->diff($today);
        $newGame = $dateInterval->days <= 5 ? true : false;
    @endphp

    @if ($newGame)
        <span class="position-absolute badge rounded-pill badge-new" style="top: -8px; right: -8px; z-index: 10;">
            Novo
            <span class="visually-hidden">new game</span>
        </span>
    @endif
    
    <div class="card-img-wrapper" style="overflow: hidden; border-radius: 16px 16px 0 0;">
        <img src="{{ $game['coverUrl'] }}" class="card-img-top" alt="{{ $game['name'] }}">
    </div>
    <div class="card-body d-flex flex-column">
        <a href="{{ route('game.details', $game['slug']) }}" class="stretched-link"></a>
        <h6 class="card-title">{{ $game['name'] }}</h6>
        @if(isset($game->genres) && $game->genres->count() > 0)
        <p class="card-subtitle mb-2 text-body-secondary" >
            <small class="badge badge-bg-green text-wrap">{{ $game->genres[0]->name }}</small>
        </p>
        @endif
        {{-- <div class="mt-auto">
            <div class="dropdown">
                <a class="btn btn-custom my-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Download
                </a>
                <ul class="dropdown-menu">
                    @foreach ($platforms[$game['game_id']] as $platform)
                        <li><a class="dropdown-item" href="{{ $platform['romUrl'] }}">{{ $platform['platform_name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div> --}}

        {{-- @if( Route::is('masterchief') )
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-warning">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button type="button" class="btn btn-danger">
                    <i class="fa-solid fa-eraser"></i>
                </button>
            </div>
        @endif --}}
    </div>
    {{-- <div class="card-footer">
        <small>added at: {{ date("F j, Y", strtotime($game["created_at"])) }}</small>
    </div>                 --}}
</div>