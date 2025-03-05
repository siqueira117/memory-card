@foreach ($games as $game)
    <div class="col-md-3 mb-3">
        <div class="card">
            <img src="{{ $game['coverUrl'] }}" class="card-img-top" alt="{{ $game['name'] }}">
            <div class="card-body">
                <h5 class="card-title">{{ $game['name'] }}</h5>
                <h6 class="card-subtitle">{{ $game['romPlatform'] }}</h6>
                <a href="{{ $game['downloadUrl'] }}" class="btn btn-custom my-3" target="_blank">Download</a>
            </div>
        </div>
    </div>
@endforeach