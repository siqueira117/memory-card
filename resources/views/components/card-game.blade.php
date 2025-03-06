<div class="row g-3">
    @foreach ($games as $game)
        <div class="col-6 col-sm-6 col-md-5 col-lg-3">
            <div class="card h-100 w-75 ">
                <img src="{{ $game['coverUrl'] }}" class="card-img-top" alt="{{ $game['name'] }}">
                <div class="card-body d-flex flex-column">
                    {{-- <a href="{{ route('game.details', $game['slug']) }}" class="stretched-link"></a> --}}
                    <h5 class="card-title">{{ $game['name'] }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        @foreach ($game->genres as $genre)
                            <span class="badge text-bg-light">{{ $genre->name }}</span>
                        @endforeach
                    </h6>
                    <div class="mt-auto">
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
                    </div>
                </div>
                <div class="card-footer">
                    <small>added at: {{ date("F j, Y", strtotime($game["created_at"])) }}</small>
                </div>                
            </div>
        </div>
    @endforeach
</div>
