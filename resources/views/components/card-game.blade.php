<div class="row g-3">
    @foreach ($games as $game)
        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
            <div class="card h-100 w-100">
                <img src="{{ $game['coverUrl'] }}" class="card-img-top" alt="{{ $game['name'] }}">
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('game.details', $game['slug']) }}" class="stretched-link"></a>
                    <h6 class="card-title">{{ $game['name'] }}</h6>
                    @php
                    $created    = new DateTime($game["created_at"]);
                    $today      = new DateTime();
            
                    $dateInterval = $created->diff($today);
                    $newGame = $dateInterval->days <= 5 ? true : false;
                @endphp
            
                @if ($newGame)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-new">
                        Novo
                    <span class="visually-hidden">unread messages</span>
                @endif
                    {{-- <h6 class="card-subtitle mb-2 text-body-secondary" >
                        @foreach ($game->genres as $genre)
                            <span class="badge text-bg-light">{{ $genre->name }}</span>
                        @endforeach
                    </h6> --}}
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

                    @if( Route::is('masterchief') )
                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-warning">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="fa-solid fa-eraser"></i>
                            </button>
                        </div>
                    @endif
                </div>
                {{-- <div class="card-footer">
                    <small>added at: {{ date("F j, Y", strtotime($game["created_at"])) }}</small>
                </div>                 --}}
            </div>
        </div>
    @endforeach
</div>
