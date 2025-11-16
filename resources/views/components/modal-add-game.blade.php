<div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content game-modal">
            <div class="modal-header border-0">
                <div class="w-100">
                    <h4 class="modal-title fw-bold mb-2">
                        <i class="fas fa-gamepad me-2"></i>Adicionar Novo Jogo
                    </h4>
                    <p class="text-secondary small mb-0">Busque um jogo no IGDB e adicione ROMs</p>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body px-4">
                <!-- Step 1: Search Game -->
                <div id="searchStep">
                    <div class="step-header mb-3">
                        <span class="step-number">1</span>
                        <h5 class="mb-0">Buscar Jogo</h5>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-search me-2"></i>Nome do Jogo
                        </label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-search input-icon"></i>
                            <input type="text" 
                                   class="form-control form-control-modern ps-5" 
                                   id="gameSearchInput" 
                                   placeholder="Digite o nome do jogo..."
                                   autocomplete="off">
                        </div>
                        <small class="form-text text-secondary mt-2">
                            <i class="fas fa-info-circle me-1"></i>Digite pelo menos 3 caracteres para buscar
                        </small>
                    </div>

                    <!-- Loading -->
                    <div id="searchLoading" class="text-center py-3" style="display: none;">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Buscando...</span>
                        </div>
                        <p class="text-secondary mt-2 mb-0">Buscando no IGDB...</p>
                    </div>

                    <!-- Search Results -->
                    <div id="searchResults" class="search-results"></div>
                </div>

                <!-- Step 2: Game Preview & ROMs -->
                <div id="romStep" style="display: none;">
                    <div class="step-header mb-3">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="backToSearch()">
                            <i class="fas fa-arrow-left me-1"></i>Voltar
                        </button>
                        <span class="step-number ms-2">2</span>
                        <h5 class="mb-0">Adicionar ROMs</h5>
                    </div>

                    <!-- Game Preview -->
                    <div id="gamePreview" class="game-preview mb-4"></div>

                    <!-- ROM Form -->
                    <form id="gameForm" action="{{ route('game.store') }}" method="post">
                        @csrf
                        <input type="hidden" id="selectedGameId" name="gameId">

                        <div id="romsContainer">
                            <div class="rom-entry mb-3">
                                <div class="rom-header mb-2">
                                    <i class="fas fa-download me-2"></i>
                                    <strong>ROM #1</strong>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label small">Plataforma</label>
                                        <select class="form-select select-modern" name="gamePlatform[]" required>
                                            <option value="" selected disabled>Selecione a plataforma</option>
                                            @foreach ($platforms as $platform)
                                                <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small">Link da ROM</label>
                                        <input type="url" 
                                               class="form-control form-control-modern" 
                                               name="gameDownload[]" 
                                               placeholder="https://..." 
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-success btn-sm mb-3 w-100" onclick="addRomEntry()">
                            <i class="fas fa-plus me-2"></i>Adicionar Outra ROM
                        </button>

                        <!-- Manual Section (Optional) -->
                        <div class="accordion accordion-flush mb-3" id="manualAccordion">
                            <div class="accordion-item bg-transparent border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed manual-accordion-btn" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#manualCollapse">
                                        <i class="fas fa-book me-2"></i>Adicionar Manual (Opcional)
                                    </button>
                                </h2>
                                <div id="manualCollapse" class="accordion-collapse collapse">
                                    <div class="accordion-body p-3 bg-dark-custom rounded mt-2">
                                        <div class="row g-2">
                                            <div class="col-md-12 mb-2">
                                                <label class="form-label small">URL do Manual</label>
                                                <input type="url" 
                                                       class="form-control form-control-modern" 
                                                       name="manualUrl" 
                                                       placeholder="https://...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Plataforma</label>
                                                <select class="form-select select-modern" name="manualPlatform">
                                                    <option value="" selected>Selecione</option>
                                                    @foreach ($platforms as $platform)
                                                        <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small">Idioma</label>
                                                <select class="form-select select-modern" name="manualLanguage">
                                                    <option value="" selected>Selecione</option>
                                                    @foreach ($languages as $language)
                                                        <option value="{{ $language->language_id }}">{{ $language->native_name }} - {{ $language->locale }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-custom">
                                <i class="fas fa-save me-2"></i>Cadastrar Jogo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.game-modal {
    background: var(--card-gradient);
    border: 1px solid var(--border-color);
    border-radius: 20px;
}

.step-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--border-color);
}

.step-number {
    width: 30px;
    height: 30px;
    background: var(--btn-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 0.9rem;
}

.step-header h5 {
    color: var(--text-primary);
    font-weight: 700;
    margin-bottom: 0;
}

.search-results {
    max-height: 400px;
    overflow-y: auto;
}

.game-result-item {
    display: flex;
    gap: 15px;
    padding: 15px;
    background: var(--dark-color);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.game-result-item:hover {
    border-color: var(--btn-color);
    background: rgba(45, 150, 27, 0.1);
    transform: translateX(5px);
}

.game-result-cover {
    width: 60px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.game-result-info {
    flex-grow: 1;
}

.game-result-title {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 4px;
}

.game-result-meta {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.game-preview {
    background: rgba(45, 150, 27, 0.05);
    border: 2px solid var(--btn-color);
    border-radius: 12px;
    padding: 15px;
}

.game-preview-content {
    display: flex;
    gap: 15px;
    align-items: start;
}

.game-preview-cover {
    width: 90px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid var(--btn-color);
}

.game-preview-info h5 {
    color: var(--text-primary);
    font-weight: 700;
    margin-bottom: 8px;
}

.game-preview-meta {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 4px;
}

.rom-entry {
    background: var(--dark-color);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 15px;
    position: relative;
}

.rom-header {
    color: var(--btn-color);
    font-size: 0.95rem;
}

.remove-rom-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 68, 68, 0.2);
    border: 1px solid #ff4444;
    color: #ff4444;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.remove-rom-btn:hover {
    background: #ff4444;
    color: white;
}

.manual-accordion-btn {
    background: var(--dark-color);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 12px 16px;
}

.manual-accordion-btn:not(.collapsed) {
    background: rgba(45, 150, 27, 0.1);
    border-color: var(--btn-color);
    color: var(--btn-color);
}

.select-modern {
    background: var(--input-color);
    border: 2px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 10px;
    padding: 10px 14px;
}

.select-modern:focus {
    border-color: var(--btn-color);
    box-shadow: 0 0 0 3px rgba(45, 150, 27, 0.1);
    background: #32323a;
}

.form-control-modern {
    background: var(--input-color) !important;
    border: 2px solid var(--border-color) !important;
    color: var(--text-primary) !important;
}

.form-control-modern:focus {
    background: #32323a !important;
    border-color: var(--btn-color) !important;
    box-shadow: 0 0 0 3px rgba(45, 150, 27, 0.15) !important;
    color: var(--text-primary) !important;
}

.input-icon-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    z-index: 1;
    pointer-events: none;
}

/* Scrollbar */
.search-results::-webkit-scrollbar {
    width: 8px;
}

.search-results::-webkit-scrollbar-track {
    background: var(--dark-color);
    border-radius: 10px;
}

.search-results::-webkit-scrollbar-thumb {
    background: var(--btn-color);
    border-radius: 10px;
}

.search-results::-webkit-scrollbar-thumb:hover {
    background: var(--btn-color-hover);
}
</style>

<script>
let romCount = 1;
let selectedGame = null;

// Search games
document.getElementById('gameSearchInput')?.addEventListener('input', debounce(function(e) {
    const query = e.target.value.trim();
    
    if (query.length < 3) {
        document.getElementById('searchResults').innerHTML = '';
        return;
    }
    
    searchGames(query);
}, 500));

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function searchGames(query) {
    const loading = document.getElementById('searchLoading');
    const results = document.getElementById('searchResults');
    
    loading.style.display = 'block';
    results.innerHTML = '';
    
    console.log('🔍 Buscando jogos:', query);
    
    fetch(`/api/games/search?q=${encodeURIComponent(query)}`)
        .then(response => {
            console.log('📡 Resposta recebida:', response.status, response.statusText);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('📦 Dados recebidos:', data);
            loading.style.display = 'none';
            
            if (data.games && data.games.length > 0) {
                console.log('✅ Jogos encontrados:', data.games.length);
                results.innerHTML = data.games.map((game, index) => {
                    // Escapar o JSON para evitar problemas com aspas
                    const gameJson = JSON.stringify(game).replace(/'/g, '&apos;').replace(/"/g, '&quot;');
                    
                    return `
                        <div class="game-result-item" data-game-index="${index}" onclick="selectGameByIndex(${index})">
                            <img src="${game.cover}" alt="${game.name}" class="game-result-cover">
                            <div class="game-result-info">
                                <div class="game-result-title">${game.name}</div>
                                <div class="game-result-meta">
                                    <i class="fas fa-calendar me-1"></i>${game.year || 'N/A'}
                                    ${game.platforms ? `<i class="fas fa-desktop ms-2 me-1"></i>${game.platforms}` : ''}
                                </div>
                            </div>
                            <div class="text-success align-self-center">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    `;
                }).join('');
                
                // Armazenar os jogos globalmente para acesso pelo índice
                window.searchResults = data.games;
            } else {
                console.log('⚠️ Nenhum jogo encontrado');
                results.innerHTML = `
                    <div class="text-center py-4 text-secondary">
                        <i class="fas fa-search fa-2x mb-2"></i>
                        <p>Nenhum jogo encontrado.</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('❌ Erro ao buscar jogos:', error);
            console.error('❌ Detalhes do erro:', error.message, error.stack);
            loading.style.display = 'none';
            results.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p>Erro ao buscar jogos.</p>
                    <small class="text-muted">${error.message}</small>
                </div>
            `;
        });
}

function selectGameByIndex(index) {
    if (window.searchResults && window.searchResults[index]) {
        console.log('🎮 Jogo selecionado:', window.searchResults[index]);
        selectGame(window.searchResults[index]);
    } else {
        console.error('❌ Jogo não encontrado no índice:', index);
    }
}

function selectGame(game) {
    selectedGame = game;
    document.getElementById('selectedGameId').value = game.id;
    
    // Show preview
    document.getElementById('gamePreview').innerHTML = `
        <div class="game-preview-content">
            <img src="${game.cover}" alt="${game.name}" class="game-preview-cover">
            <div class="game-preview-info flex-grow-1">
                <h5>${game.name}</h5>
                <div class="game-preview-meta">
                    <i class="fas fa-calendar me-1"></i>Lançamento: ${game.year || 'N/A'}
                </div>
                ${game.platforms ? `<div class="game-preview-meta"><i class="fas fa-desktop me-1"></i>${game.platforms}</div>` : ''}
                ${game.genres ? `<div class="game-preview-meta"><i class="fas fa-tag me-1"></i>${game.genres}</div>` : ''}
            </div>
        </div>
    `;
    
    // Switch steps
    document.getElementById('searchStep').style.display = 'none';
    document.getElementById('romStep').style.display = 'block';
}

function backToSearch() {
    document.getElementById('searchStep').style.display = 'block';
    document.getElementById('romStep').style.display = 'none';
    selectedGame = null;
}

function addRomEntry() {
    romCount++;
    const container = document.getElementById('romsContainer');
    const newEntry = document.createElement('div');
    newEntry.className = 'rom-entry mb-3';
    newEntry.innerHTML = `
        <button type="button" class="remove-rom-btn" onclick="removeRomEntry(this)">
            <i class="fas fa-times"></i>
        </button>
        <div class="rom-header mb-2">
            <i class="fas fa-download me-2"></i>
            <strong>ROM #${romCount}</strong>
        </div>
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label small">Plataforma</label>
                <select class="form-select select-modern" name="gamePlatform[]" required>
                    <option value="" selected disabled>Selecione a plataforma</option>
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform->platform_id }}">{{ $platform->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small">Link da ROM</label>
                <input type="url" 
                       class="form-control form-control-modern" 
                       name="gameDownload[]" 
                       placeholder="https://..." 
                       required>
            </div>
        </div>
    `;
    container.appendChild(newEntry);
}

function removeRomEntry(btn) {
    btn.closest('.rom-entry').remove();
    updateRomNumbers();
}

function updateRomNumbers() {
    const entries = document.querySelectorAll('.rom-entry');
    entries.forEach((entry, index) => {
        entry.querySelector('.rom-header strong').textContent = `ROM #${index + 1}`;
    });
    romCount = entries.length;
}
</script>
