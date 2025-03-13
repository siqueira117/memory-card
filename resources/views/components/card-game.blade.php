<div class="row g-3">
    @foreach ($games as $game)
        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
            <x-card-game-unique :game="$game" />
        </div>
    @endforeach
</div>
