@foreach ($games as $game)
    <div class="col-md-3 mb-3">
        <div class="card">
            <img src="{{ $game['coverUrl'] }}" class="card-img-top" alt="{{ $game['name'] }}">
            <div class="card-body">
                <h5 class="card-title">{{ $game['name'] }}</h5>
                <div class="dropdown">
                    <a class="btn btn-custom my-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Download
                    </a>
                  
                    <ul class="dropdown-menu">
                        @foreach ($platforms[$game['game_id']] as $platform)
                            <li><a class="dropdown-item" href="{{ $platform['romUrl'] }}">{{$platform['platform_name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach