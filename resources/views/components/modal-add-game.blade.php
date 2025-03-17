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
                        <label for="gameDownload" class="form-label">Link para Download</label>
                        <input type="url" id="gameDownload" name="gameDownload" required>
                    </div>
                    <div class="mb-3">
                        <label for="gamePlatform" class="form-label">Plataforma da ROM:</label>
                        <select class="form-select select-black" aria-label="platforms" name="gamePlatform" required>
                            <option selected disabled ="*">Plataforma</option>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="accordion mb-3 accordion-flush" id="accordionOptions">
                        <div class="accordion-item">
                          <h2 class="accordion-header">
                            <button class="accordion-button btn-accordion collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              Manual
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionOptions">
                            <div class="accordion-body bg-dark">
                                <div class="mb-3">
                                    <label for="manualUrl" class="form-label text-light">URL:</label>
                                    <input type="url" id="manualUrl" name="manualUrl">
                                </div>
                                <div class="mb-3">
                                    <label for="platform-options-manual" class="form-label text-light">Plataforma do Manual:</label>
                                    <select class="form-select select-black" aria-label="platforms" name="manualPlatform" required>
                                        <option selected disabled ="*">Plataforma</option>
                                        @foreach ($platforms as $platform)
                                            <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="language-options-manual" class="form-label text-light">Plataforma do Manual:</label>
                                    <select class="form-select select-black" aria-label="platforms" name="manualLanguage" required>
                                        <option selected disabled ="*">Linguagens</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->language_id }}">{{ $language->native_name }} - {{ $language->locale }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-custom w-100" value="Salvar">
                </form>
            </div>
        </div>
    </div>
</div>