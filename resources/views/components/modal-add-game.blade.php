<div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="gameModalLabel">Adicionar Novo Jogo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="gameForm" action="{{ route('game.store')}}" method="post" >
                    @csrf
                    <div class="mb-3">
                        <label for="gameId" class="form-label">IGDB ID:</label>
                        <input type="text" id="gameId" name="gameId">
                    </div>
                    <div class="mb-3">
                        <label for="gameName" class="form-label">Nome do Jogo</label>
                        <input type="text" id="gameName" name="gameName" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="gameCover" class="form-label">URL da Capa</label>
                        <input type="url" id="gameCover" required>
                    </div> --}}
                    <div class="mb-3">
                        <label for="gameDownload" class="form-label">Link para Download</label>
                        <input type="url" id="gameDownload" name="gameDownload" required>
                    </div>
                    <div class="mb-3">
                        <label for="platform-options" class="form-label">Plataforma da ROM:</label>
                        <select class="form-select platform-options" aria-label="platforms" name="gamePlatform" required>
                            <option selected disabled ="*">Plataforma</option>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" class="btn btn-custom w-100" value="Salvar">
                </form>
            </div>
        </div>
    </div>
</div>