<div class="modal fade" id="gameManualModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="gameModalLabel">Adicionar Novo Manual</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="gameForm" action="{{ route('manual.store')}}" method="post" >
                    @csrf
                    <div class="mb-3">
                        <label for="manualGame" class="form-label">IGDB ID:</label>
                        <input type="text" id="manualGame" name="manualGame">
                    </div>
                    <div class="mb-3">
                        <label for="manualUrl" class="form-label text-light">URL:</label>
                        <input type="url" id="manualUrl" name="manualUrl">
                    </div>
                    <div class="mb-3">
                        <label for="platform-options-manual" class="form-label text-light">Plataforma do Manual:</label>
                        <select class="form-select select-black" id="platform-options-manual" aria-label="platformsManual" name="manualPlatform" required>
                            <option value="*" selected disabled>Plataforma</option>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language-options-manual" class="form-label text-light">Idioma do Manual:</label>
                        <select class="form-select select-black" id="language-options-manual" aria-label="languages" name="manualLanguage" required>
                            <option selected disabled value="*">Linguagens</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->language_id }}">{{ $language->native_name }} - {{ $language->locale }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" class="btn btn-custom w-100" value="Salvar">
                </form>
            </div>
        </div>
    </div>
</div>