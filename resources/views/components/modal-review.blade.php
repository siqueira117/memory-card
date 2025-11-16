@props(['game'])

<!-- Modal de Review -->
<div id="reviewModal" class="review-modal">
    <div class="review-modal-content">
        <div class="review-modal-header">
            <h3 id="reviewModalTitle">Avaliar Jogo</h3>
            <button type="button" class="review-modal-close" onclick="closeReviewModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="reviewForm" onsubmit="submitReview(event)">
            <input type="hidden" name="game_id" value="{{ $game->game_id }}" id="review_game_id">
            <input type="hidden" name="review_id" id="review_id" value="">

            <!-- Rating -->
            <div class="review-form-group">
                <div class="review-rating-section">
                    <label class="review-rating-label">
                        Sua Avaliação <span class="required">*</span>
                    </label>
                    <x-star-rating :rating="0" :interactive="true" size="xl" name="rating" />
                </div>
            </div>

            <!-- Review Text -->
            <div class="review-form-group">
                <label>Seu Review (opcional)</label>
                <textarea 
                    name="review" 
                    id="review_text"
                    class="review-textarea" 
                    placeholder="Conte-nos o que você achou deste jogo... (Opcional)"
                    maxlength="5000"
                ></textarea>
                <small class="text-muted">
                    <span id="reviewCharCount">0</span>/5000 caracteres
                </small>
            </div>

            <!-- Spoiler Warning -->
            <div class="review-form-group">
                <div class="review-checkbox-group">
                    <input type="checkbox" name="spoiler" id="review_spoiler" value="1">
                    <label for="review_spoiler">
                        <i class="fas fa-exclamation-triangle"></i>
                        Meu review contém spoilers
                    </label>
                </div>
            </div>

            <!-- Status -->
            <div class="review-form-group">
                <label for="review_status">Status (opcional)</label>
                <select name="status" id="review_status" class="review-select">
                    <option value="">Selecione...</option>
                    <option value="playing">🎮 Jogando</option>
                    <option value="completed">✅ Completado</option>
                    <option value="dropped">⏸️ Pausado</option>
                    <option value="plan_to_play">📋 Quero Jogar</option>
                </select>
            </div>

            <!-- Horas Jogadas -->
            <div class="review-form-group">
                <label for="review_hours">Horas Jogadas (opcional)</label>
                <input 
                    type="number" 
                    name="hours_played" 
                    id="review_hours" 
                    class="review-input"
                    min="0"
                    max="10000"
                    placeholder="Ex: 50"
                >
            </div>

            <!-- Data que Jogou -->
            <div class="review-form-group">
                <label for="review_played_at">Quando Jogou? (opcional)</label>
                <input 
                    type="date" 
                    name="played_at" 
                    id="review_played_at" 
                    class="review-input"
                    max="{{ date('Y-m-d') }}"
                >
            </div>

            <!-- Botões -->
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" class="btn-secondary" onclick="closeReviewModal()" style="flex: 1;">
                    Cancelar
                </button>
                <button type="submit" class="btn-custom" style="flex: 2;">
                    <i class="fas fa-save"></i>
                    <span id="reviewSubmitText">Publicar Review</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border: 1px solid #2a2a2e;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: #ffffff;
}
</style>

<script>
// Contador de caracteres
document.getElementById('review_text')?.addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('reviewCharCount').textContent = count;
});

// Abrir modal para criar review
function openReviewModal() {
    const modal = document.getElementById('reviewModal');
    document.getElementById('reviewModalTitle').textContent = 'Avaliar Jogo';
    document.getElementById('reviewSubmitText').textContent = 'Publicar Review';
    document.getElementById('review_id').value = '';
    document.getElementById('reviewForm').reset();
    
    // Reset rating
    const ratingInput = document.getElementById('rating_input');
    if (ratingInput) ratingInput.value = '0';
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Abrir modal para editar review
function openEditReviewModal(review) {
    const modal = document.getElementById('reviewModal');
    document.getElementById('reviewModalTitle').textContent = 'Editar Avaliação';
    document.getElementById('reviewSubmitText').textContent = 'Salvar Alterações';
    
    // Preencher form com dados do review
    document.getElementById('review_id').value = review.id;
    document.getElementById('rating_input').value = review.rating;
    document.getElementById('review_text').value = review.review || '';
    document.getElementById('review_spoiler').checked = review.spoiler;
    document.getElementById('review_status').value = review.status || '';
    document.getElementById('review_hours').value = review.hours_played || '';
    document.getElementById('review_played_at').value = review.played_at ? review.played_at.split(' ')[0] : '';
    
    // Atualizar visual das estrelas
    const stars = document.querySelectorAll('.star-rating-interactive .star');
    stars.forEach((star, index) => {
        const icon = star.querySelector('i');
        if (index < review.rating) {
            star.className = 'star star-filled';
            icon.className = 'fas fa-star';
        } else {
            star.className = 'star star-empty';
            icon.className = 'far fa-star';
        }
    });
    
    // Atualizar contador de caracteres
    document.getElementById('reviewCharCount').textContent = (review.review || '').length;
    
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Fechar modal
function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Fechar modal ao clicar fora
document.getElementById('reviewModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});

// Submit do review
async function submitReview(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const reviewId = document.getElementById('review_id').value;
    const rating = document.getElementById('rating_input').value;
    
    // Validar rating
    if (!rating || rating === '0') {
        alert('Por favor, selecione uma avaliação (estrelas)');
        return;
    }
    
    const data = {
        game_id: formData.get('game_id'),
        rating: parseInt(rating),
        review: formData.get('review') || null,
        spoiler: formData.get('spoiler') === '1',
        status: formData.get('status') || null,
        hours_played: formData.get('hours_played') ? parseInt(formData.get('hours_played')) : null,
        played_at: formData.get('played_at') || null,
    };
    
    try {
        const url = reviewId ? `/api/reviews/${reviewId}` : '/api/reviews';
        const method = reviewId ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (response.ok) {
            alert(result.message || 'Review salvo com sucesso!');
            closeReviewModal();
            // Recarregar página para mostrar o review
            window.location.reload();
        } else {
            if (result.errors) {
                const errors = Object.values(result.errors).flat().join('\n');
                alert('Erros:\n' + errors);
            } else {
                alert(result.error || 'Erro ao salvar review');
            }
        }
    } catch (error) {
        console.error('Erro ao enviar review:', error);
        alert('Erro ao enviar review. Tente novamente.');
    }
}

// Deletar review
async function deleteReview(reviewId) {
    if (!confirm('Tem certeza que deseja deletar seu review?')) {
        return;
    }
    
    try {
        const response = await fetch(`/api/reviews/${reviewId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const result = await response.json();
        
        if (response.ok) {
            alert(result.message || 'Review deletado com sucesso!');
            window.location.reload();
        } else {
            alert(result.error || 'Erro ao deletar review');
        }
    } catch (error) {
        console.error('Erro ao deletar review:', error);
        alert('Erro ao deletar review. Tente novamente.');
    }
}

// Revelar spoiler
function revealSpoiler(element) {
    element.classList.add('revealed');
    element.previousElementSibling.style.display = 'none';
}
</script>

